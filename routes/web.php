<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AlunoController;

Route::get('/', [BibliotecaController::class, 'index']);

Route::get('/menu', [BibliotecaController::class, 'menu'])->middleware('auth')->name('menu');

Route::get('/alunos/lista', [AlunoController::class, 'index']);

Route::get('/livros/lista', [LivroController::class, 'index']);

Route::get('/livro/cadastrar', [LivroController::class, 'create']);

Route::get('/livro/{id}', [LivroController::class, 'show']);

Route::post('/livros', [LivroController::class, 'store']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
