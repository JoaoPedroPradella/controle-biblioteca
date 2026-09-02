@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <h1>Cadastre um Novo Livro</h1>
@endsection
@section('main')
    <form action="/livros" method="POST">
        @csrf
        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" required><br>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" required><br>

        <label for="editora">Editora:</label>
        <input type="text" name="editora" id="editora" required><br>

        <label for="data_publicacao">Data de publicação:</label>
        <input type="date" name="data_pub" id="data_pub" required><br>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" required><br>

        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" id="idioma" required><br>

        <label for="qtd_pag">Quantidade de páginas:</label>
        <input type="number" min="1" name="qtd_pag" id="qtd_pag" required><br>

        <div>
            <label for="formato">Formato:</label>
            <select name="formato" id="formato" required>
                <option value="fisico">Físico</option>
                <option value="ebook">Ebook</option>
            </select>
        </div>

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
        <textarea name="sinopse" id="sinopse" rows="4" cols="50" required></textarea><br>


        <input type="submit" value="Cadastrar">
    </form>

@endsection
