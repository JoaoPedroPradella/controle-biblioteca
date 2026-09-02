<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AlunoController;

Route::get('/', [BibliotecaController::class, 'index']);

Route::get('/menu', [BibliotecaController::class, 'menu']);

Route::get('/alunos-lista', [AlunoController::class, 'index']);

Route::get('/livros-lista', [LivroController::class, 'index']);

Route::get('/livro-cadastrar', [LivroController::class, 'create']);

Route::post('/livros', [LivroController::class, 'store']);