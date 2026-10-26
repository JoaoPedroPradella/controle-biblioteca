@extends('layouts.main')

@section('title', 'Livros')

@section('header')
    <h1>Livros</h1>
@endsection

@section('page-actions')
    @if (!Auth::user()->aluno)
        <a class="btn" href="/livro/cadastrar">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
            Novo livro
        </a>
    @endif
@endsection

@section('main')
    <section class="catalog-toolbar" aria-label="Busca de livros">
        <form class="catalog-search" action="/livros/lista" method="GET">
            <label class="sr-only" for="busca">Buscar livro</label>
            <div class="filter-control">
                <input type="search" name="busca" id="busca" value="{{ $busca }}" placeholder="Buscar por título">
                <span class="filter-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" /><path d="m16 16 4 4" /></svg>
                </span>
            </div>
            <button class="btn" type="submit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6" /><path d="m16 16 4 4" /></svg>
                Buscar
            </button>
            @if ($busca)
                <a class="btn btn--secondary" href="/livros/lista">Limpar busca</a>
            @endif
        </form>
    </section>

    @if ($busca)
        <p class="filter-summary">Resultados para “{{ $busca }}”.</p>
    @endif

    <section class="books-grid" aria-label="Livros cadastrados">
        @forelse ($livros as $livro)
            <article class="book-card">
                <a class="book-cover" href="/livro/{{ $livro->id }}" aria-label="Ver detalhes de {{ $livro->titulo }}">
                    @if ($livro->imagem)
                        <img src="/img/livros/{{ $livro->imagem }}" alt="Capa de {{ $livro->titulo }}">
                    @else
                        <span class="book-cover-placeholder" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21V5.5ZM20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5A2.5 2.5 0 0 1 20 21V5.5Z" /></svg>
                        </span>
                    @endif
                </a>

                <div class="book-card-content">
                    <span class="book-genre">{{ $livro->genero }}</span>
                    <h2><a href="/livro/{{ $livro->id }}">{{ $livro->titulo }}</a></h2>
                    <p class="book-author">{{ $livro->autor }}</p>
                    <p class="book-publisher">{{ $livro->editora }}</p>
                </div>

                <footer class="book-card-actions">
                    <a class="btn btn--small" href="/livro/{{ $livro->id }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" /><circle cx="12" cy="12" r="2.5" /></svg>
                        Detalhes
                    </a>

                    @if (!Auth::user()->aluno)
                        <a class="icon-action" href="/livro/editar/{{ $livro->id }}" aria-label="Editar {{ $livro->titulo }}" title="Editar">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 20h4l11-11a2.8 2.8 0 0 0-4-4L4 16v4Z" /><path d="m13.5 6.5 4 4" /></svg>
                        </a>
                        <form action="/livro/{{ $livro->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="icon-action icon-action--danger" type="submit" aria-label="Apagar {{ $livro->titulo }}" title="Apagar">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M10 11v6m4-6v6M9 7l1-3h4l1 3m-9 0 1 13h10l1-13" /></svg>
                            </button>
                        </form>
                    @endif
                </footer>
            </article>
        @empty
            <div class="catalog-empty">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21V5.5ZM20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5A2.5 2.5 0 0 1 20 21V5.5Z" /></svg>
                <h2>Nenhum livro encontrado</h2>
                <p>{{ $busca ? 'Tente buscar por outro título.' : 'Ainda não há livros cadastrados no acervo.' }}</p>
                @if ($busca)
                    <a class="btn btn--secondary" href="/livros/lista">Ver todos os livros</a>
                @endif
            </div>
        @endforelse
    </section>

    @if ($livros->isNotEmpty())
        <p class="catalog-count">{{ $livros->count() }} {{ $livros->count() === 1 ? 'livro encontrado' : 'livros encontrados' }}</p>
    @endif
@endsection
