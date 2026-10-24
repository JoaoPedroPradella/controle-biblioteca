@extends('layouts.main')

@section('title', 'emprestimos')

@section('header')
    <button><a href="../menu">Menu</a></button>
    <h1>Lista de Emprestimos</h1>
@endsection
@section('main')

    {{-- Somente alunos podem realizar os empréstimos --}}
    @if (Auth::user()->aluno->id ?? false)
        <a href="/emprestimo/cadastrar"><button>Novo Empréstimo</button></a>
    @endif

    {{-- <form action="/emprestimos/lista" method="GET">
        <input type="text" name="busca" id="busca" placeholder="Busca livro/aluno/codigo patrimonio">
    </form> --}}

    <form action="/emprestimos/lista" method="GET">
        <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar empréstimo">

        <select name="status" onchange="this.form.submit()">
            <option value="">Todos os status</option>
            <option value="ativo" @selected($status === 'ativo')>Ativo</option>
            <option value="atrasado" @selected($status === 'atrasado')>Atrasado</option>
            <option value="devolvido" @selected($status === 'devolvido')>Devolvido</option>
        </select>

        <div>
            <label for="data_inicial">Data inicial</label>
            <input type="date" name="data_inicial" id="data_inicial" value="{{ $dataInicial }}">
        </div>

        <div>
            <label for="data_final">Data final</label>
            <input type="date" name="data_final" id="data_final" value="{{ $dataFinal }}">
        </div>

        <button type="submit">Filtrar</button>
        <button type="button" onclick="window.location.href='/emprestimos/lista'">Limpar filtros</button>
    </form>
    @if ($busca)
        <h2>Buscando por: {{ $busca }}</h2>
    @endif

    <p>Esta é a lista de emprestimos</p>
    @foreach ($emprestimos as $emprestimo)
        {{-- As chaves são usadas para exibir o valor no html, por isso no if não usamos --}}

        <p>ID: {{ $emprestimo->id }}</p>
        <p>Aluno: {{ $emprestimo->user->name }}</p>
        <p>Livro: {{ $emprestimo->exemplar->livro->titulo }}</p>
        <p>Exemplar (Patrimônio): {{ $emprestimo->exemplar->codigo_patrimonio }}</p>
        <p>ID do exemplar: {{ $emprestimo->exemplar->id }}</p>
        <p>Data de Empréstimo: {{ $emprestimo->data_retirada->format('d/m/Y') }}</p>
        <p>Data Prevista para Devolução: {{ $emprestimo->data_prev_dev->format('d/m/Y') }}</p>
        @if ($emprestimo->data_dev)
            <p>Data de Devolução: {{ $emprestimo->data_dev->format('d/m/Y') }}</p>
        @endif


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

        @if (!$emprestimo->data_dev)
            <form action = "/emprestimo/{{ $emprestimo->exemplar->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Registrar Devolução</button>

                <br>
                <br>
            </form>
        @endif
    @endforeach
    {{-- @if (count($emprestimos) == 0)
        <p>Não foi possível encontrar nenhum emprestimo com {{ $busca }}! <a href="/emprestimos/lista">Ver todos</a></p>
    @elseif 
    --}}
    @if (count($emprestimos) == 0)
        <p>Não há emprestimos cadastrados</p>
    @endif
@endsection
