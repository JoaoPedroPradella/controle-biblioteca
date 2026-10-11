<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Aluno;
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

        // User::whith('aluno')->get() -> traz todos os alunos com seus respectivos alunos, por conta do relacionamento definido no model User
        if ($busca) {
            $alunos = User::with('aluno')->where([
                ['name', 'like', '%' . $busca . '%']
            ])->get();
        } else {
            $alunos = User::with('aluno')->get();
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
        $aluno = new Aluno;
        $usuario = new User;

        // if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
        //     $requestImagem = $request->imagem;

        //     $extensao = $requestImagem->extension();

        //     // O md5 transforma essa informação em uma sequência de 32 caracteres hexadecimais
        //     $nomeImagem = md5($requestImagem->getClientOriginalName() . strtotime("now")) . "." . $extensao;

        //     $requestImagem->move(public_path('img/livros'), $nomeImagem);

        //     $data['imagem'] = $nomeImagem;
        // }
        
        $usuario->name = $request->nome;
        $aluno->cpf = $request->cpf;
        $aluno->data_nasc = $request->data_nasc;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->type = 'aluno';

        Aluno::findOrFail($aluno)->update($data);
        User::findOrFail($usuario)->update($data);


        return redirect('/livros/lista')->with('msg', 'Livro editado com sucesso!');
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
