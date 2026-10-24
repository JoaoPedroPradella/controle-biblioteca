@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <button type="button" onclick="history.back()" aria-label="Voltar">&larr;</button>
    <h1>Cadastre um Novo Usuario</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    <form action="/usuario" method="POST" enctype="multipart/form-data">
        @csrf
        <x-validation-errors class="mb-4" />
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="e-mail">E-mail:</label>
        <input type="text" name="email" id="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br>

        {{-- Incluido campo de confirmação de senha para poder validar a senha no controller usando o passwordRules() do Fortify --}}
        <label for="senha_confirmation">Confirmar senha:</label>
        <input type="password" name="senha_confirmation" id="senha_confirmation" required>

        <input type="submit" value="Cadastrar">
    </form>

@endsection
