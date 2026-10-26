@extends('layouts.main')

@section('title', 'Usuários')

@section('header')
    <h1>Usuários</h1>
@endsection

@section('page-actions')
    <a class="btn" href="/usuario/cadastrar">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
        Novo usuário
    </a>
@endsection

@section('main')
    <section class="catalog-toolbar" aria-label="Busca de usuários">
        <form class="catalog-search" action="/usuarios/lista" method="GET">
            <label class="sr-only" for="busca">Buscar usuário</label>
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
                <a class="btn btn--secondary" href="/usuarios/lista">Limpar busca</a>
            @endif
        </form>
    </section>

    @if ($busca)
        <p class="filter-summary">Resultados para “{{ $busca }}”.</p>
    @endif

    <section class="directory-card" aria-label="Lista de usuários">
        <table class="directory-table">
            <thead>
                <tr>
                    <th scope="col">Usuário</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr>
                        <td>
                            <div class="directory-person">
                                <span class="directory-avatar" aria-hidden="true">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
                                <span>
                                    <strong>{{ $usuario->name }}</strong>
                                    <span>{{ $usuario->email }}</span>
                                </span>
                            </div>
                        </td>
                        <td>{{ $usuario->type }}</td>
                        <td>
                            <span class="status-label {{ $usuario->situation === 'ativo' ? 'status-label--active' : '' }}">
                                {{ $usuario->situation }}
                            </span>
                        </td>
                        <td>
                            <div class="directory-actions">
                                <a class="btn btn--small btn--secondary" href="/usuario/{{ $usuario->id }}">Detalhes</a>
                                <a class="btn btn--small" href="/usuario/editar/{{ $usuario->id }}">Editar</a>
                                <form action="/usuario/{{ $usuario->id }}" method="POST">
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
                            {{ $busca ? "Não foi possível encontrar nenhum usuário com {$busca}." : 'Não há usuários cadastrados.' }}
                            @if ($busca)
                                <a href="/usuarios/lista">Ver todos</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
