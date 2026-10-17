@extends('layouts.main')

@section('title', '$usuario->name')

@section('header')
    <h1>Detalhes do usuário {{ $usuario->name }}</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    {{-- <div>
        @if ($livro->imagem)
            <img src="/img/livros/{{ $livro->imagem }}" alt="Imagem do Livro {{ $livro->titulo }}" width="200">
        @else
            <p>Sem imagem</p>
        @endif
    </div> --}}
    <div>
        <p>Nome: {{ $usuario->name }}</p>
        <p>E-mail: {{ $usuario->email }}</p>
        <p>Tipo: {{ $usuario->type }}</p>
        <p>Situação: {{ $usuario->situation }}</p>
        <p>Data de cadastro: {{ $usuario->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <a href="/usuarios/lista"><button>Lista</button></a>

@endsection
