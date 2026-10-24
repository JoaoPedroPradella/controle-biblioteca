@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <button type="button" onclick="history.back()" aria-label="Voltar">&larr;</button>
    <h1>Cadastre um Novo Livro</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    <form action="/livros" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" id="titulo" required><br>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" required><br>

        <label for="editora">Editora:</label>
        <input type="text" name="editora" id="editora" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" id="isbn" maxlength="13" required><br>

        <label for="data_publicacao">Data de publicação:</label>
        <input type="date" name="data_pub" id="data_pub" required><br>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" required><br>

        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" id="idioma" required><br>

        <label for="qtd_pag">Quantidade de páginas:</label>
        <input type="number" min="1" name="qtd_pag" id="qtd_pag" required><br>

        <div>
            <label for="tipo_capa">Tipo da Capa:</label>
            <select name="tipo_capa" id="tipo_capa" required>
                <option value="capa_dura">Capa Dura</option>
                <option value="brochura">Brochura</option>
            </select>
        </div>

        <div>
            <label for="sinopse">Sinopse:</label>
        </div>
        <textarea name="sinopse" id="sinopse" rows="4" cols="50"></textarea><br>

        <label for="qtd_exemp">Quantidade de Exemplares:</label>
        <input type="number" min="1" name="qtd_exemp" id="qtd_exemp" required><br>

        <label for="imagem">Imagem do Livro:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*"><br>


        <input type="submit" value="Cadastrar">
    </form>

@endsection
