@extends('layouts.main')

@section('title', '$livro->titulo')

@section('header')
    <h1>Detalhes do livro {{ $livro->titulo }}</h1>
@endsection
@section('main')
{{-- enctype é necessário para enviar arquivos por um form html--}}
    <div>
        @if ($livro->imagem)
            <img src="/img/livros/{{ $livro->imagem }}" alt="Imagem do Livro {{ $livro->titulo }}" width="200">
        @else
            <p>Sem imagem</p>
        @endif
    </div>
    <div>
        <p>Titulo: {{ $livro->titulo }}</p>
        <p>Autor: {{ $livro->autor }}</p>
        <p>Editora: {{ $livro->editora }}</p>
        <p>Data de publicação: {{ $livro->data_pub }}</p>
        <p>Gênero: {{ $livro->genero }}</p>
        <p>Idioma: {{ $livro->idioma }}</p>
        <p>Quantidade de páginas: {{ $livro->qtd_pag }}</p>
        <p>Formato: {{ $livro->formato }}</p>
        <p>Tipo da Capa: {{ $livro->tipo_capa }}</p>
        <div>
            <label for="sinopse">Sinopse:</label>
            <textarea name="sinopse" id="sinopse" rows="4" cols="50" readonly>{{ $livro->sinopse }}</textarea><br>
        </div>
    </div>

@endsection
