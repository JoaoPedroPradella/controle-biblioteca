<?php

namespace App\Http\Controllers;

use App\Models\Exemplare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Livro;


class LivroController extends Controller
{
    /**
     * Index - Lista de livros cadastrados
     */
    public function index()
    {
        $busca = request('busca');

        if ($busca) {
            $livros = Livro::where([
                ['titulo', 'like', '%' . $busca . '%'],
                ['ativo', '=', true]
            ])->get();
        } else {
            $livros = Livro::where('ativo', true)->get();
        }

        return view('livros/index', ['livros' => $livros, 'busca' => $busca]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('livros/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $livro = new Livro;


        $dados = $request->validate([
            'titulo' => 'required|string|max:200',
            'autor' => 'required|string|max:100',
            'editora' => 'required|string|max:150',
            'isbn' => 'nullable|string|max:13',
            'data_pub' => 'required|date',
            'genero' => 'required|string|max:100',
            'idioma' => 'required|string|max:100',
            'qtd_pag' => 'required|integer|min:1|max:500',
            'tipo_capa' => 'nullable|in:brochura,capa_dura',
            'sinopse' => 'nullable|string',
            'qtd_exemp' => 'required|integer|min:1|max:500',
        ]);


        // $livro->titulo = $request->titulo;
        // $livro->autor = $request->autor;
        // $livro->editora = $request->editora;
        // $livro->data_pub = $request->data_pub;
        // $livro->genero = $request->genero;
        // $livro->idioma = $request->idioma;
        // $livro->qtd_pag = $request->qtd_pag;
        // $livro->formato = $request->formato;
        // $livro->tipo_capa = $request->tipo_capa;
        // $livro->sinopse = $request->sinopse;

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImagem = $request->imagem;

            $extensao = $requestImagem->extension();

            // O md5 transforma essa informação em uma sequência de 32 caracteres hexadecimais
            $nomeImagem = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extensao;

            $requestImagem->move(public_path('img/livros'), $nomeImagem);

            $livro->imagem = $nomeImagem;
        }

        DB::transaction(function () use ($dados) {

            // Guarda a quantidade antes de criar o livro
            $qtd_exemp = $dados['qtd_exemp'];

            unset($dados['qtd_exemp']);

            // Cadastra o livro
            $livro = Livro::create($dados);

            // Cria os exemplares vinculados ao livro
            for ($i = 0; $i < $qtd_exemp; $i++) {
                $livro->exemplares()->create([
                    'status' => 'disponivel',
                ]);
            }
        });

        // $livro->save();

        return redirect('/livros/lista')->with('msg', 'Livro cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // FindOrFail - busca o livro pelo id, se não encontrar retorna erro 404
        $livro = Livro::findOrFail($id);

        return view('livros/show', ['livro' => $livro]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $livro = Livro::findOrFail($id);

        return view('livros/edit', ['livro' => $livro]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $livro = Livro::findOrFail($request->id);

        $dados = $request->all();
        // $status_exemplares = $request->input('status_exemplares', []);

        // unset($data['status']);

        $statusExemplares = $dados['status_exemplares'] ?? [];

        unset($dados['status_exemplares']);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImagem = $request->imagem;

            $extensao = $requestImagem->extension();

            // O md5 transforma essa informação em uma sequência de 32 caracteres hexadecimais
            $nomeImagem = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extensao;

            $requestImagem->move(public_path('img/livros'), $nomeImagem);

            $data['imagem'] = $nomeImagem;
        }

        DB::transaction(function () use (
            $livro,
            $dados,
            $statusExemplares
        ) {
            $livro->update($dados);

            // A variável statusExemplares é um array com ID e status dos exemplares.
            // Quando falamos no "foreach" $id => $status, estamos percorrendo esse array, onde $id é a chave (ID do exemplar) e $status é o valor (novo status do exemplar).
            foreach ($statusExemplares as $id => $status) {
                $exemplar = Exemplare::where('livro_id', $livro->id)->findOrFail($id);

                // Não permitir alterar manualmente um exemplar emprestado.
                if ($exemplar->status === 'emprestado') {
                    abort(422, 'Não é permitido alterar manualmente o status de um exemplar emprestado.');
                }

                $exemplar->update([
                    'status' => $status,
                ]);
            }
        });


        return redirect('/livros/lista')->with('msg', 'Livro editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $livro = Livro::findOrFail($id);

        $possuiEmprestimos = $livro->exemplares()
            ->whereHas('emprestimos')
            ->exists();

        if ($possuiEmprestimos) {
            $livro->update(['ativo' => false]);
            return redirect('/livros/lista')->with(
                'msg',
                'Não é possível excluir o livro, pois um ou mais exemplares possuem empréstimos vinculados. O livro foi desativado.'
            );
        }

        $livro->exemplares()->delete();
        $livro->delete();

        return redirect('/livros/lista')->with('msg', 'Livro excluído com sucesso!');
    }
}
