@extends('layouts.main')

@section('title', '$aluno->titulo')

@section('header')
    <h1>Detalhes do aluno {{ $usuario->name }}</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    {{-- <div>
        @if ($aluno->imagem)
            <img src="/img/alunos/{{ $aluno->imagem }}" alt="Imagem do aluno {{ $aluno->titulo }}" width="200">
        @else
            <p>Sem imagem</p>
        @endif
    </div> --}}
    <div>
        <p>Nome: {{ $usuario->name }}</p>
        <p>CPF: {{ $aluno->cpf }}</p>
        <p>Data de Nascimento: {{ $aluno->data_nasc->format('d/m/Y') }}</p>
        <p>Matricula: {{ $aluno->matricula }}</p>
        <p>E-mail: {{ $usuario->email }}</p>
        <p>Tipo: {{ $usuario->type }}</p>
        <p>Situação: {{ $usuario->situation }}</p>
        <p>Data de cadastro: {{ $usuario->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <a href="/alunos/lista"><button>Lista</button></a>
@endsection
