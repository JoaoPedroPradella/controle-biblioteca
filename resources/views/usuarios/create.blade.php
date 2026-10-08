@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <h1>Cadastre um Novo Usuario</h1>
@endsection
@section('main')
{{-- enctype é necessário para enviar arquivos por um form html--}}
    <form action="/usuarios" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" required><br>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nasc" id="data_nasc" required><br>

        <label for="e-mail">E-mail:</label>
        <input type="text" name="email" id="email" required><br>

        <label for="senha">Senha:</label>
        <input type="text" name="senha" id="senha" required><br>

        <div>
            <label for="tipo_usuario">Tipo de usuário:</label>
            <select name="tipo" id="tipo" required>
                <option value="aluno">Aluno</option>
                <option value="ebook">Administrador</option>
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
        <textarea name="sinopse" id="sinopse" rows="4" cols="50"></textarea><br>

        <label for="imagem">Imagem do Livro:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*"><br>


        <input type="submit" value="Cadastrar">
    </form>

@endsection
