@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <button type="button" onclick="history.back()" aria-label="Voltar">&larr;</button>
    <h1>Cadastre um Novo Aluno</h1>
@endsection
@section('main')
{{-- enctype é necessário para enviar arquivos por um form html--}}
    <form action="/aluno" method="POST" enctype="multipart/form-data">
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
        <input type="password" name="senha" id="senha" required><br>

        <input type="submit" value="Cadastrar">
    </form>

@endsection
