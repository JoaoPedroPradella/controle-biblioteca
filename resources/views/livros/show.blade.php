@extends('layouts.main')

@section('title', $livro->titulo)

@section('header')
    <h1>{{ $livro->titulo }}</h1>
@endsection

@section('page-actions')
    @if (!Auth::user()->aluno)
        <a class="btn btn--secondary" href="/livro/editar/{{ $livro->id }}">Editar livro</a>
    @endif
@endsection

@section('main')
    <a class="content-back-link" href="/livros/lista">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
        Voltar para livros
    </a>

    <section class="details-card">
        <div class="details-layout">
            <div class="details-cover">
                @if ($livro->imagem)
                    <img src="/img/livros/{{ $livro->imagem }}" alt="Capa de {{ $livro->titulo }}">
                @else
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21V5.5ZM20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5A2.5 2.5 0 0 1 20 21V5.5Z" /></svg>
                @endif
            </div>

            <dl class="details-grid">
                <div class="detail-item"><dt>Autor</dt><dd>{{ $livro->autor }}</dd></div>
                <div class="detail-item"><dt>Editora</dt><dd>{{ $livro->editora }}</dd></div>
                <div class="detail-item"><dt>Gênero</dt><dd>{{ $livro->genero }}</dd></div>
                <div class="detail-item"><dt>Idioma</dt><dd>{{ $livro->idioma }}</dd></div>
                <div class="detail-item"><dt>Publicação</dt><dd>{{ date('d/m/Y', strtotime($livro->data_pub)) }}</dd></div>
                <div class="detail-item"><dt>Páginas</dt><dd>{{ $livro->qtd_pag }}</dd></div>
                <div class="detail-item"><dt>ISBN</dt><dd>{{ $livro->isbn ?: 'Não informado' }}</dd></div>
                <div class="detail-item"><dt>Tipo de capa</dt><dd>{{ $livro->tipo_capa === 'capa_dura' ? 'Capa dura' : 'Brochura' }}</dd></div>
                <div class="detail-item detail-item--full"><dt>Sinopse</dt><dd class="synopsis-text">{{ $livro->sinopse ?: 'Sinopse não informada.' }}</dd></div>
            </dl>
        </div>

        <section class="details-section">
            <h2>Exemplares</h2>
            @if ($livro->exemplares->isEmpty())
                <p class="directory-muted">Não há exemplares cadastrados para este livro.</p>
            @else
                <ul class="exemplar-list">
                    @foreach ($livro->exemplares as $exemplar)
                        <li>
                            <strong>{{ $exemplar->codigo_patrimonio }}</strong>
                            <span>Exemplar {{ $loop->iteration }} · {{ ucfirst($exemplar->status) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </section>
@endsection
