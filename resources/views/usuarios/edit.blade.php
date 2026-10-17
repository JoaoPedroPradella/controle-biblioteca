@extends('layouts.main')

@section('title', '$usuario->name')

@section('header')
    <h1>Detalhes do usuário {{ $usuario->name }}</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    {{-- <div>
        @if ($usuario->imagem)
            <img src="/img/usuarios/{{ $usuario->imagem }}" alt="Imagem do usuario {{ $usuario->email }}" width="200">
        @else
            <p>Sem imagem</p>
        @endif
    </div> --}}
    <form action="/usuario/update/{{ $usuario->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="{{ $usuario->name }}"><br>

            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" required value="{{ $usuario->email }}"><br>

        </div>
        <input type="submit" value="Editar">
    </form>
    <a href="/usuarios/lista"><button>Lista</button></a>

@endsection
