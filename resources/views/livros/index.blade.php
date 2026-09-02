@extends('layouts.main')

@section('title', 'Livros')

@section('header')

    <h1>Lista de Livros</h1>

    <a href="/livro-cadastrar"><button>Novo</button></a>

@endsection
@section('main')
    <p>Esta é a lista de livros</p>
    @foreach ($livros as $livro)
        <p>{{ $livro->descricao }}</p>
        <p>{{ $livro->autor }}</p>
        <p>{{ $livro->genero }}</p>
    @endforeach
@endsection
