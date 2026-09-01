<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Livro;

class BibliotecaController extends Controller
{
    public function index () {
        return view('login');
    }

    public function menu () {
        return view('menu');
    }

     public function aluno_lista () {
        return view('alunos_lista');
    }

    public function livro_lista () {

        $livros = Livro::all();

        return view('livros_lista',['livros' => $livros]);
    }
    
}
