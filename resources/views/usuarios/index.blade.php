@extends('layouts.main')

@section('title', 'Usuarios')

@section('header')
    <button><a href="../menu">Menu</a></button>
    <h1>Lista de Usuarios</h1>
@endsection
@section('main')
    <a href="/usuario/cadastrar"><button>Novo</button></a>
    <form action="/usuarios/lista" method="GET">
        <input type="text" name="busca" id="busca" placeholder="Buscar Usuario">
    </form>
    @if ($busca)
        <h2>Buscando por: {{ $busca }}</h2>
    @endif
    <p>Esta é a lista de Usuarios</p>
    @foreach ($usuarios as $usuario)
        {{-- As chaves são usadas para exibir o valor no html, por isso no if não usamos --}}
        @if ($usuario->imagem)
            <img src="/img/usuarios/{{ $usuario->imagem }}" alt="Imagem do usuario {{ $usuario->titulo }}" width="200">
        @endif
        <p>Nome: {{ $usuario->name }}</p>
        <p>Autor: {{ $usuario->email }}</p>
        <a href="/usuario/{{ $usuario->id }}">Detalhes</a>
        <a href="/usuario/editar/{{ $usuario->id }}">Editar</a>
        <form action = "/usuario/{{ $usuario->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Apagar</button>
            <br>
            <br>
        </form>
    @endforeach
    @if (count($usuarios) == 0 && $busca)
        <p>Não foi possível encontrar nenhum usuario com {{ $busca }}! <a href="/usuarios/lista">Ver todos</a></p>
    @elseif (count($usuarios) == 0)
        <p>Não há usuarios cadastrados</p>
    @endif
@endsection
