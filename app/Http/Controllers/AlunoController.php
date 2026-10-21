<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Aluno;
use App\Models\Emprestimo;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class AlunoController extends Controller
{
    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $busca = request('busca');

        // Aluno::with('user') traz os dados do aluno junto com os dados do usuário relacionado, evitando consultas adicionais ao banco de dados.
        // Busca apenas os alunos cujo usuário vinculado tenha o nome informado na pesquisa
        if ($busca) {
            $alunos = Aluno::with('user')->whereHas('user', function ($query) use ($busca) {
                $query->where('name', 'like', '%' . $busca . '%');
            })->get();
        } else {
            $alunos = Aluno::whereHas('user')->get();
        }
        return view('alunos/index', ['alunos' => $alunos, 'busca' => $busca]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alunos/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $aluno = new Aluno;
        $usuario = new User;

        // $request->validate([
        //     'password' => $this->passwordRules(),
        // ]);

        do {
            $matricula = random_int(100000, 999999);
        } while (Aluno::where('matricula', $matricula)->exists());

        $usuario->name = $request->nome;
        $aluno->cpf = $request->cpf;
        $aluno->data_nasc = $request->data_nasc;
        $aluno->matricula = $matricula;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->type = 'aluno';

        // if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
        //     $requestImagem = $request->imagem;

        //     $extensao = $requestImagem->extension();

        //     // O md5 transforma essa informação em uma sequência de 32 caracteres hexadecimais
        //     $nomeImagem = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extensao;

        //     $requestImagem->move(public_path('img/livros'), $nomeImagem);

        //     $livro->imagem = $nomeImagem;
        // }
        $usuario->save();

        $usuario->aluno()->save($aluno);

        return redirect('/alunos/lista')->with('msg', 'Aluno cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aluno = Aluno::findOrFail($id);
        $usuario = User::findOrFail($aluno->user_id);

        return view('alunos/show', ['aluno' => $aluno, 'usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aluno = Aluno::findOrFail($id);
        $usuario = User::findOrFail($aluno->user_id);

        return view('alunos/edit', ['aluno' => $aluno, 'usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $aluno = Aluno::findOrFail($id);

        $aluno->update([
            'cpf' => $request->cpf,
            'data_nasc' => $request->data_nasc,
        ]);

        $aluno->user->update([
            'name' => $request->nome,
            'email' => $request->email,
        ]);

        return redirect('/alunos/lista')->with('msg', 'Aluno editado com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aluno = Aluno::findOrFail($id);

        if (Emprestimo::where('aluno_id', $id)->exists()) {
            $aluno->update(['ativo' => false]);
            $aluno->user->update(['situation' => "inativo"]);
            return redirect('/alunos/lista')->with('msg', 'Não é possível excluir este aluno, pois ele possui empréstimos vinculados. O Aluno foi desativado.');
        } else {
            $aluno->delete(); // Deleta o aluno
            $aluno->user->delete(); // Deleta o usuário associado ao aluno
            return redirect('/alunos/lista')->with('msg', 'Aluno excluído com sucesso!');
        }


    }
}
