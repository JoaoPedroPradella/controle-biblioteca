<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlunoController;


Route::get('/', [BibliotecaController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // -------------------------- Rotas para Livros --------------------------
    // Rota para exibir a lista de livros cadastrados
    Route::get('/livros/lista', [LivroController::class, 'index']);

    // Rota para exibir o formulário de cadastro de livros
    Route::get('/livro/cadastrar', [LivroController::class, 'create']);

    // Rota para exibir os detalhes de um livro específico
    Route::get('/livro/{id}', [LivroController::class, 'show']);

    // Rota para cadastrar um novo livro
    Route::post('/livros', [LivroController::class, 'store']);

    // Rota para deletar um livro específico
    Route::delete('/livro/{id}', [LivroController::class, 'destroy']);

    // Rota para exibir o formulário de edição do livro
    Route::get('/livro/editar/{id}', [LivroController::class, 'edit']);

    // Rota para atualizar um livro
    Route::put('/livro/update/{id}', [LivroController::class, 'update']);

    // -------------------------- Rotas para Usuarios --------------------------
    Route::get('/alunos/lista', [AlunoController::class, 'index']);

    Route::get('/aluno/cadastrar', [AlunoController::class, 'create']);

    Route::post('/aluno', [AlunoController::class, 'store']);

    Route::get('/aluno/{id}', [AlunoController::class, 'show']);

    Route::get('/aluno/editar/{id}', [AlunoController::class, 'edit']);

    Route::put('/aluno/update/{id}', [AlunoController::class, 'update']);

    Route::delete('/aluno/{id}', [AlunoController::class, 'destroy']);

    Route::get('/menu',  function () {
        return view('menu');
    })->name('menu');
});
