<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;

Route::get('/', [BibliotecaController::class, 'index']);

Route::get('/menu', [BibliotecaController::class, 'menu']);

Route::get('/alunos-lista', [BibliotecaController::class, 'aluno_lista']);

Route::get('/livros-lista', [BibliotecaController::class, 'livro_lista']);