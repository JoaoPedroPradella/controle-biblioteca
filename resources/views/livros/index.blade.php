@extends('layouts.main')

@section('title', 'Livros')

@section('header')
    <button><a href="../menu">Menu</a></button>
    <h1>Lista de Livros</h1>
@endsection
@section('main')
    @if (!Auth::user()->aluno)
        <a href="/livro/cadastrar"><button>Novo</button></a>
    @endif
    <form action="/livros/lista" method="GET">
        <input type="text" name="busca" id="busca" placeholder="Buscar livro">
    </form>
    @if ($busca)
        <h2>Buscando por: {{ $busca }}</h2>
    @endif
    <p>Esta é a lista de livros</p>
    @foreach ($livros as $livro)
        {{-- As chaves são usadas para exibir o valor no html, por isso no if não usamos --}}
        @if ($livro->imagem)
            <img src="/img/livros/{{ $livro->imagem }}" alt="Imagem do Livro {{ $livro->titulo }}" width="200">
        @endif
        <p>Titulo: {{ $livro->titulo }}</p>
        <p>Autor: {{ $livro->autor }}</p>
        <p>Genero: {{ $livro->genero }}</p>

        @if (Auth::user()->aluno->id ?? false)
            <a href="/livro/{{ $livro->id }}">Detalhes</a>
        @else
            <a href="/livro/{{ $livro->id }}">Detalhes</a>
            <a href="/livro/editar/{{ $livro->id }}">Editar</a>
            <form action = "/livro/{{ $livro->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Apagar</button>
                <br>
                <br>
        @endif
    @endforeach

    @if (count($livros) == 0)
        <p>Não foi possível encontrar nenhum livro com {{ $busca }}! <a href="/livros/lista">Ver todos</a></p>
    @elseif (count($livros) == 0)
        <p>Não há livros cadastrados</p>
    @endif
@endsection
