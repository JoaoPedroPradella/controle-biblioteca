@extends('layouts.main')

@section('title', 'emprestimos')

@section('header')
    <button><a href="../menu">Menu</a></button>
    <h1>Lista de Emprestimos</h1>
@endsection
@section('main')
    {{-- @php
        dd($emprestimos);
    @endphp --}}
    <a href="/emprestimo/cadastrar"><button>Novo Empréstimo</button></a>
    {{-- <form action="/emprestimos/lista" method="GET">
        <input type="text" name="busca" id="busca" placeholder="Buscar Emprestimo">
    </form>
    @if ($busca)
        <h2>Buscando por: {{ $busca }}</h2>
    @endif --}}
    <p>Esta é a lista de emprestimos</p>
    @foreach ($emprestimos as $emprestimo)
        {{-- As chaves são usadas para exibir o valor no html, por isso no if não usamos --}}
        {{-- @if ($emprestimo->imagem)
            <img src="/img/emprestimos/{{ $emprestimo->imagem }}" alt="Imagem do emprestimo {{ $emprestimo->titulo }}" width="200">
        @endif --}}

        <p>ID: {{ $emprestimo->id }}</p>
        <p>Aluno: {{ $emprestimo->user->name }}</p>
        <p>Livro: {{ $emprestimo->exemplar->livro->titulo }}</p>
        <p>Exemplar (Patrimônio): {{ $emprestimo->exemplar->codigo_patrimonio }}</p>
        <p>Exemplar (Patrimônio): {{ $emprestimo->exemplar->codigo_patrimonio }}</p>
        <p>Data de Empréstimo: {{ $emprestimo->data_retirada }}</p>
        <p>Data de Devolução: {{ $emprestimo->data_dev }}</p>
        {{-- ?? quer dizer null, então se o valor for null use false --}}
        <p>Status: 
            @if ($emprestimo->data_dev)
                Devolvido
            @elseif ($emprestimo->data_prev_dev->lt(today()) && !$emprestimo->data_dev)
                Atrasado
            @else
                Ativo
            @endif
        </p>
        <a href=""><button>Detalhes</button></a>
        <a href=""><button>Registrar Devolução</button></a>

        <form action = "/emprestimo/{{ $emprestimo->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Apagar</button>
            <br>
            <br>
    @endforeach
    {{-- @if (count($emprestimos) == 0)
        <p>Não foi possível encontrar nenhum emprestimo com {{ $busca }}! <a href="/emprestimos/lista">Ver todos</a></p>
    @elseif 
    --}}
    @if (count($emprestimos) == 0)
        <p>Não há emprestimos cadastrados</p>
    @endif
@endsection
