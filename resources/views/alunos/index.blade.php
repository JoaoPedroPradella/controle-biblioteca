@extends('layouts.main')

@section('title', 'Alunos')

@section('header')
    <h1>Alunos</h1>
@endsection

@section('page-actions')
    <a class="btn" href="/aluno/cadastrar">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
        Novo aluno
    </a>
@endsection

@section('main')
    <section class="catalog-toolbar" aria-label="Busca de alunos">
        <form class="catalog-search" action="/alunos/lista" method="GET">
            <label class="sr-only" for="busca">Buscar aluno</label>
            <div class="filter-control">
                <input type="search" name="busca" id="busca" value="{{ $busca }}" placeholder="Buscar por nome">
                <span class="filter-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" /><path d="m16 16 4 4" /></svg>
                </span>
            </div>
            <button class="btn" type="submit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6" /><path d="m16 16 4 4" /></svg>
                Buscar
            </button>
            @if ($busca)
                <a class="btn btn--secondary" href="/alunos/lista">Limpar busca</a>
            @endif
        </form>
    </section>

    @if ($busca)
        <p class="filter-summary">Resultados para “{{ $busca }}”.</p>
    @endif

    <section class="directory-card" aria-label="Lista de alunos">
        <table class="directory-table">
            <thead>
                <tr>
                    <th scope="col">Aluno</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Matrícula</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alunos as $aluno)
                    <tr>
                        <td>
                            <div class="directory-person">
                                <span class="directory-avatar" aria-hidden="true">{{ strtoupper(substr($aluno->user->name, 0, 1)) }}</span>
                                <span>
                                    <strong>{{ $aluno->user->name }}</strong>
                                    <span>{{ $aluno->user->email }}</span>
                                </span>
                            </div>
                        </td>
                        <td>{{ $aluno->cpf }}</td>
                        <td>{{ $aluno->matricula }}</td>
                        <td>
                            <div class="directory-actions">
                                <a class="btn btn--small btn--secondary" href="/aluno/{{ $aluno->id }}">Detalhes</a>
                                <a class="btn btn--small" href="/aluno/editar/{{ $aluno->id }}">Editar</a>
                                <form action="/aluno/{{ $aluno->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn--small btn--danger" type="submit">Apagar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="empty-table" colspan="4">
                            {{ $busca ? "Não foi possível encontrar nenhum aluno com {$busca}." : 'Não há alunos cadastrados.' }}
                            @if ($busca)
                                <a href="/alunos/lista">Ver todos</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
