<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Aluno;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class UsuarioController extends Controller
{
    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $busca = request('busca');

        // User::whereDoesntHave('aluno')->get() -> Retorna somente os usuários que não tem vinculo com alunos, ou seja usuários do tipo ADM.
        if ($busca) {
            $usuarios = User::whereDoesntHave('aluno')->where([
                ['name', 'like', '%' . $busca . '%']
            ])->get();
        } else {
            $usuarios = User::whereDoesntHave('aluno')->get();
        }
        return view('usuarios/index', ['usuarios' => $usuarios, 'busca' => $busca]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios/create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     */


    public function store(Request $request)
    {



        Validator::make(
            $request->all(),
            [
                'nome' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'senha' => $this->passwordRules(),
            ],

            [
                'required' => 'O campo :attribute é obrigatório.',
                'email' => 'Informe um e-mail válido.',
                'unique' => 'Este :attribute já está cadastrado.',
                'confirmed' => 'A confirmação de senha não confere.',
                'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            ],
            // Os atributos abaixo são usados para personalizar as mensagens de erro, substituindo o nome do campo pelo valor definido.
            [
                'nome' => 'nome',
                'email' => 'e-mail',
                'senha' => 'senha',
            ]
        )->validate();

        User::create([
            'name' => $request['nome'],
            'email' => $request['email'],
            'password' => Hash::make($request['senha']),
            'type' => 'admin'
        ]);

        return redirect('/usuarios/lista')->with('msg', 'Usuario cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id);

        return view('usuarios/show', ['usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);

        return view('usuarios/edit', ['usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        Validator::make(
            $request->all(),
            [
                'nome' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ],

            [
                'required' => 'O campo :attribute é obrigatório.',
                'email' => 'Informe um e-mail válido.',
                'unique' => 'Este :attribute já está cadastrado.',
                'confirmed' => 'A confirmação de senha não confere.',
                'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            ],
            // Os atributos abaixo são usados para personalizar as mensagens de erro, substituindo o nome do campo pelo valor definido.
            [
                'nome' => 'nome',
                'email' => 'e-mail',
            ]
        )->validate();

        $usuario = User::findOrFail($id);

        $usuario->name = $request->input('nome');
        $usuario->email = $request->input('email');

        $usuario->save();

        return redirect('/usuarios/lista')->with('msg', 'Usuario atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect('/usuarios/lista')->with('msg', 'Usuario excluído com sucesso!');
    }
}
