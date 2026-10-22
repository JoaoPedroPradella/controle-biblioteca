<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Depoi vou implementar as buscas aqui, mas por enquanto vou apenas retornar todos os emprestimos

        // Filtro para trazer os emprestimos do usuário logado, caso ele seja um aluno. Se for um ADM, traz todos os emprestimos
        // ?? quer dizer null, então se o valor for null use false
        if (Auth::user()->aluno->id ?? false) {
             $id_user_logado = Auth::user()->aluno->id;
             $emprestimos = Emprestimo::with('aluno.user', 'user', 'exemplar.livro')->where('aluno_id', $id_user_logado)->get();
        } else {
              $id_user_logado = Auth::user()->id;
              $emprestimos = Emprestimo::with('aluno.user', 'user', 'exemplar.livro')->get();
        };

        return view('emprestimos/index', ['emprestimos' => $emprestimos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emprestimos/create');
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
