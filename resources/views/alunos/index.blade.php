@extends('layouts.main')

@section('title', 'alunos')

@section('header')
    <button><a href="../menu">Menu</a></button>
    <h1>Lista de alunos</h1>
@endsection
@section('main')
    <a href="/aluno/cadastrar"><button>Novo</button></a>
    <form action="/alunos/lista" method="GET">
        <input type="text" name="busca" id="busca" placeholder="Buscar aluno">
    </form>
    @if ($busca)
        <h2>Buscando por: {{ $busca }}</h2>
    @endif
    <p>Esta é a lista de alunos</p>
    @foreach ($alunos as $aluno)
        {{-- As chaves são usadas para exibir o valor no html, por isso no if não usamos --}}
        @if ($aluno->imagem)
            <img src="/img/alunos/{{ $aluno->imagem }}" alt="Imagem do aluno {{ $aluno->titulo }}" width="200">
        @endif
        <p>Nome: {{ $aluno->user->name }}</p>
        <p>E-mail: {{ $aluno->user->email }}</p>
        <p>Matricula: {{ $aluno->matricula }}</p>
        <a href="/aluno/{{ $aluno->id }}">Detalhes</a>
        <a href="/aluno/editar/{{ $aluno->id }}">Editar</a>
        <form action = "/aluno/{{ $aluno->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Apagar</button>
            <br>
            <br>
        </form>
    @endforeach
    @if (count($alunos) == 0 && $busca)
        <p>Não foi possível encontrar nenhum aluno com {{ $busca }}! <a href="/alunos/lista">Ver todos</a></p>
    @elseif (count($alunos) == 0)
        <p>Não há alunos cadastrados</p>
    @endif
@endsection
