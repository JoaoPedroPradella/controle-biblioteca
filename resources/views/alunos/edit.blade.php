@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <h1>Editando o aluno {{ $usuario->name }}</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    <form action="/aluno/update/{{ $aluno->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required value="{{ $usuario->name }}"><br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" required value="{{ $aluno->cpf }}"><br>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nasc" id="data_nasc" required
            value="{{ date('Y-m-d', strtotime($aluno->data_nasc)) }}"><br>

        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" required value="{{ $usuario->email }}"><br>

        {{-- <label for="imagem">Imagem do aluno:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*"><br>
        <div>
            @if ($aluno->imagem)
                <img src="/img/alunos/{{ $aluno->imagem }}" alt="Imagem do aluno {{ $aluno->titulo }}" width="200">
            @else
                <p>Sem imagem</p>
            @endif
        </div> --}}
        <input type="submit" value="Editar">
    </form>

@endsection
