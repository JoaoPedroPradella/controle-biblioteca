<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Livro;


class LivroController extends Controller
{
    /**
     * Index - Lista de livros cadastrados
     */
    public function index()
    {
        $livros = Livro::all();

        return view('livros/index', ['livros' => $livros]);
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

        $livro->titulo = $request->titulo;
        $livro->autor = $request->autor;
        $livro->editora = $request->editora;
        $livro->data_pub = $request->data_pub;
        $livro->genero = $request->genero;
        $livro->idioma = $request->idioma;
        $livro->qtd_pag = $request->qtd_pag;
        $livro->formato = $request->formato;
        $livro->tipo_capa = $request->tipo_capa;
        $livro->sinopse = $request->sinopse;

        if($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImagem = $request->imagem;

            $extensao = $requestImagem->extension();

            // O md5 transforma essa informação em uma sequência de 32 caracteres hexadecimais
            $nomeImagem = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extensao;

            $requestImagem->move(public_path('img/livros'), $nomeImagem);

            $livro->imagem = $nomeImagem;

        }

        $livro->save();

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
