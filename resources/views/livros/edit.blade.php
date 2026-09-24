@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <h1>Editando o livro {{ $livro->titulo }}</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    <form action="/livro/update/{{ $livro->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" id="titulo" required value="{{ $livro->titulo }}"><br>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" required value="{{ $livro->autor }}"><br>

        <label for="editora">Editora:</label>
        <input type="text" name="editora" id="editora" required value="{{ $livro->editora }}"><br>

        <label for="data_publicacao">Data de publicação:</label>
        <input type="date" name="data_pub" id="data_pub" required
            value="{{ date('Y-m-d', strtotime($livro->data_pub)) }}"><br>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" required value="{{ $livro->genero }}"><br>

        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" id="idioma" required value="{{ $livro->idioma }}"><br>

        <label for="qtd_pag">Quantidade de páginas:</label>
        <input type="number" min="1" name="qtd_pag" id="qtd_pag" required value="{{ $livro->qtd_pag }}"><br>

        <div>
            <label for="formato">Formato:</label>
            <select name="formato" id="formato" required>
                <option value="fisico">Físico</option>
                <option value="ebook" {{ $livro->formato == 'ebook' ? "selected='selected'" : '' }}>Ebook</option>
            </select>
        </div>

        <div>
            <label for="tipo_capa">Tipo da Capa:</label>
            <select name="tipo_capa" id="tipo_capa" required>
                <option value="capa_dura">Capa Dura</option>
                <option value="brochura" {{ $livro->tipo_capa == 'brochura' ? "selected='selected'" : '' }}>Brochura
                </option>
            </select>
        </div>

        <div>
            <label for="sinopse">Sinopse:</label>
        </div>
        <textarea name="sinopse" id="sinopse" rows="4" cols="50">{{ $livro->sinopse }}</textarea><br>

        <label for="imagem">Imagem do Livro:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*"><br>
        <div>
            @if ($livro->imagem)
                <img src="/img/livros/{{ $livro->imagem }}" alt="Imagem do Livro {{ $livro->titulo }}" width="200">
            @else
                <p>Sem imagem</p>
            @endif
        </div>
        <input type="submit" value="Editar">
    </form>

@endsection
