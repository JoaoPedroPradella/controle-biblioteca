@extends('layouts.main')

@section('title', 'Editar usuário')

@section('header')
    <h1>Editar usuário</h1>
@endsection

@section('main')
    <div class="form-page">
        <a class="content-back-link" href="/usuario/{{ $usuario->id }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
            Voltar para detalhes
        </a>

        <form class="form-card" action="/usuario/update/{{ $usuario->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <header>
                <h2>Dados do usuário</h2>
                <p>As alterações serão salvas no cadastro existente.</p>
            </header>

            <div class="form-grid">
                <div class="form-field form-field--full">
                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" required value="{{ $usuario->name }}">
                </div>

                <div class="form-field form-field--full">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" required value="{{ $usuario->email }}">
                </div>
            </div>

            <footer class="form-actions">
                <a class="btn btn--secondary" href="/usuario/{{ $usuario->id }}">Cancelar</a>
                <button class="btn" type="submit">Salvar alterações</button>
            </footer>
        </form>
    </div>
@endsection
