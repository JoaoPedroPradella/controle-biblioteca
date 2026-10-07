<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UsuarioController;


Route::get('/', [BibliotecaController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/usuarios/lista', [UsuarioController::class, 'index']);

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



    Route::get('/menu',  function () {
        return view('menu');
    })->name('menu');
});
