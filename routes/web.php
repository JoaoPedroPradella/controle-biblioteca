<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AlunoController;


Route::get('/', [BibliotecaController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/alunos/lista', [AlunoController::class, 'index']);

    Route::get('/livros/lista', [LivroController::class, 'index']);

    Route::get('/livro/cadastrar', [LivroController::class, 'create']);

    Route::get('/livro/{id}', [LivroController::class, 'show']);

    Route::post('/livros', [LivroController::class, 'store']);

    
    Route::get('/menu',  function () {
        return view('menu');
    })->name('menu');

    
});
