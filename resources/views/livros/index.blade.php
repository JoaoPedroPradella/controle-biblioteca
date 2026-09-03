@extends('layouts.main')

@section('title', 'Livros')

@section('header')

    <h1>Lista de Livros</h1>

    <a href="/livro/cadastrar"><button>Novo</button></a>

@endsection
@section('main')
    <p>Esta é a lista de livros</p>
    @foreach ($livros as $livro)
        {{-- As chaves são usadas para exibir o valor no html, por isso no if não usamos --}}
        @if ($livro->imagem)
            <img src="/img/livros/{{ $livro->imagem }}" alt="Imagem do Livro {{ $livro->titulo }}" width="200">
        @endif
        <p>Titulo: {{ $livro->titulo }}</p>
        <p>Autor: {{ $livro->autor }}</p>
        <p>Genero: {{ $livro->genero }}</p>
        <a href="/livro/{{ $livro->id }}">Detalhes</a>
        <br>
        <br>
    @endforeach
@endsection
