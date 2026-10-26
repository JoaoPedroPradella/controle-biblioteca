@extends('layouts.main')

@section('title', 'Empréstimos')

@section('header')
    <h1>Empréstimos</h1>
@endsection

@section('page-actions')
    @if (Auth::user()?->aluno)
        <a class="btn" href="/emprestimo/cadastrar">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
            Novo Empréstimo
        </a>
    @endif
@endsection

@section('main')
    <section class="loan-filter-card" aria-label="Filtros de empréstimos">
        <form class="loan-filter-form" action="/emprestimos/lista" method="GET">
            <div class="filter-field">
                <label for="busca">Buscar</label>
                <div class="filter-control">
                    <input type="search" name="busca" id="busca" value="{{ $busca }}" placeholder="Aluno, livro, exemplar...">
                    <span class="filter-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" /><path d="m16 16 4 4" /></svg>
                    </span>
                </div>
            </div>

            <div class="filter-field">
                <label for="status">Status</label>
                <div class="filter-control">
                    <select name="status" id="status" data-auto-submit>
                        <option value="">Todos</option>
                        <option value="ativo" @selected($status === 'ativo')>Ativo</option>
                        <option value="atrasado" @selected($status === 'atrasado')>Atrasado</option>
                        <option value="devolvido" @selected($status === 'devolvido')>Devolvido</option>
                    </select>
                </div>
            </div>

            <div class="filter-field">
                <label for="data_inicial">Data inicial</label>
                <div class="filter-control">
                    <input type="date" name="data_inicial" id="data_inicial" value="{{ $dataInicial }}">
                    <span class="filter-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2" /><path d="M8 3v4m8-4v4M4 10h16" /></svg>
                    </span>
                </div>
            </div>

            <div class="filter-field">
                <label for="data_final">Data final</label>
                <div class="filter-control">
                    <input type="date" name="data_final" id="data_final" value="{{ $dataFinal }}">
                    <span class="filter-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="15" rx="2" /><path d="M8 3v4m8-4v4M4 10h16" /></svg>
                    </span>
                </div>
            </div>

            <div class="filter-actions">
                <button class="btn" type="submit">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6" /><path d="m16 16 4 4" /></svg>
                    Filtrar
                </button>
                <a class="btn btn--secondary" href="/emprestimos/lista">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 11a8 8 0 1 0 2 5.3" /><path d="M20 4v7h-7" /></svg>
                    Limpar filtros
                </a>
            </div>
        </form>
    </section>

    @if ($busca || $status || $dataInicial || $dataFinal)
        <p class="filter-summary">Exibindo os resultados conforme os filtros aplicados.</p>
    @endif

    <section class="table-card" aria-label="Lista de empréstimos">
        <table class="loan-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Aluno</th>
                    <th scope="col">Livro</th>
                    <th scope="col">Exemplar (Patrimônio)</th>
                    <th scope="col">Data do empréstimo</th>
                    <th scope="col">Data da devolução</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($emprestimos as $emprestimo)
                    @php
                        $statusEmprestimo = $emprestimo->data_dev
                            ? 'Devolvido'
                            : ($emprestimo->data_prev_dev->lt(today()) ? 'Atrasado' : 'Ativo');
                        $classeStatus = strtolower($statusEmprestimo);
                    @endphp
                    <tr>
                        <td class="loan-id">{{ $emprestimo->id }}</td>
                        <td>
                            <span class="cell-main">{{ $emprestimo->aluno->user->name }}</span>
                            <span class="cell-subtitle">Matrícula: {{ $emprestimo->aluno->matricula }}</span>
                        </td>
                        <td>
                            <a href="/livro/{{ $emprestimo->exemplar->livro->id }}">{{ $emprestimo->exemplar->livro->titulo }}</a>
                            <span class="cell-subtitle">{{ $emprestimo->exemplar->livro->autor }}</span>
                        </td>
                        <td>{{ $emprestimo->exemplar->codigo_patrimonio }}</td>
                        <td>{{ $emprestimo->data_retirada->format('d/m/Y') }}</td>
                        <td>{{ $emprestimo->data_dev?->format('d/m/Y') ?? '—' }}</td>
                        <td><span class="status-badge status-badge--{{ $classeStatus }}">{{ $statusEmprestimo }}</span></td>
                        <td>
                            <div class="table-actions">
                                <a class="btn btn--small" href="/livro/{{ $emprestimo->exemplar->livro->id }}">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" /><circle cx="12" cy="12" r="2.5" /></svg>
                                    Ver
                                </a>
                                @if (!$emprestimo->data_dev)
                                    <form action="/emprestimo/{{ $emprestimo->exemplar->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn--small btn--danger" type="submit">
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 14 4 12l5-2" /><path d="M4 12h10a6 6 0 0 1 6 6" /></svg>
                                            Devolver
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="empty-table" colspan="8">Nenhum empréstimo foi encontrado com os filtros informados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="table-footer">
            <span>Mostrando {{ $emprestimos->count() }} {{ $emprestimos->count() === 1 ? 'registro' : 'registros' }}</span>
        </div>
    </section>
@endsection
