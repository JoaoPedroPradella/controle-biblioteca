<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BibliotecaController;

Route::get('/', [BibliotecaController::class, 'index']);

Route::get('/menu', [BibliotecaController::class, 'menu']);
