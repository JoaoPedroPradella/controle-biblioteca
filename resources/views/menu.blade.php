@extends('layouts.main')

@section('title', 'Leia+')

@section('header')
    <h1>Menu Leia+</h1>
@endsection
@section('main')
    <a href="/alunos/lista"><button>Alunos</button></a>
    <a href="/livros/lista"><button>Livros</button></a>
    <a href="/emprestimos/lista"><button>Empréstimos</button></a>
    <a href="/usuarios/lista"><button>Usuários</button></a>
@endsection
@section('footer')
