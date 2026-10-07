<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Aluno;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $busca = request('busca');

        // User::whith('aluno')->get() -> traz todos os usuarios com seus respectivos alunos, por conta do relacionamento definido no model User
        if ($busca) {
            $usuarios = User::with('aluno')->where([
                ['name', 'like', '%' . $busca . '%']
            ])->get();
        } else {
            $usuarios = User::with('aluno')->get();
        }
        return view('usuarios/index', ['usuarios' => $usuarios, 'busca' => $busca]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
