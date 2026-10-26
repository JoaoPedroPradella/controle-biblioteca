@extends('layouts.main')

@section('title', $usuario->name)

@section('header')
    <h1>{{ $usuario->name }}</h1>
@endsection

@section('page-actions')
    <a class="btn btn--secondary" href="/usuario/editar/{{ $usuario->id }}">Editar usuário</a>
@endsection

@section('main')
    <a class="content-back-link" href="/usuarios/lista">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
        Voltar para usuários
    </a>

    <section class="details-card">
        <dl class="details-grid">
            <div class="detail-item detail-item--full">
                <dt>Nome</dt>
                <dd>{{ $usuario->name }}</dd>
            </div>
            <div class="detail-item detail-item--full">
                <dt>E-mail</dt>
                <dd>{{ $usuario->email }}</dd>
            </div>
            <div class="detail-item">
                <dt>Tipo de usuário</dt>
                <dd>{{ $usuario->type }}</dd>
            </div>
            <div class="detail-item">
                <dt>Situação</dt>
                <dd>{{ $usuario->situation }}</dd>
            </div>
            <div class="detail-item detail-item--full">
                <dt>Data de cadastro</dt>
                <dd>{{ $usuario->created_at->format('d/m/Y H:i:s') }}</dd>
            </div>
        </dl>
    </section>
@endsection
