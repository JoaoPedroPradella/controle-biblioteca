@extends('layouts.main')

@section('title', 'Novo usuário')

@section('header')
    <h1>Novo usuário</h1>
@endsection

@section('main')
    <div class="form-page">
        <a class="content-back-link" href="/usuarios/lista">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
            Voltar para usuários
        </a>

        <form class="form-card" action="/usuario" method="POST" enctype="multipart/form-data">
            @csrf

            <header>
                <h2>Informações do usuário</h2>
                <p>Defina os dados de acesso para o novo usuário.</p>
            </header>

            <x-validation-errors class="form-validation-errors" />

            <div class="form-grid">
                <div class="form-field form-field--full">
                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="form-field form-field--full">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" required>
                </div>

                <div class="form-field">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                </div>

                <div class="form-field">
                    <label for="senha_confirmation">Confirmar senha</label>
                    <input type="password" name="senha_confirmation" id="senha_confirmation" required>
                </div>
            </div>

            <footer class="form-actions">
                <a class="btn btn--secondary" href="/usuarios/lista">Cancelar</a>
                <button class="btn" type="submit">Cadastrar usuário</button>
            </footer>
        </form>
    </div>
@endsection
