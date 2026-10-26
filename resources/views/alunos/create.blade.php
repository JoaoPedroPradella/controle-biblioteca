@extends('layouts.main')

@section('title', 'Novo aluno')

@section('header')
    <h1>Novo aluno</h1>
@endsection

@section('main')
    <div class="form-page">
        <a class="content-back-link" href="/alunos/lista">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
            Voltar para alunos
        </a>

        <form class="form-card" action="/aluno" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-field form-field--full">
                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="form-field">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" required>
                </div>

                <div class="form-field">
                    <label for="data_nasc">Data de nascimento</label>
                    <input type="date" name="data_nasc" id="data_nasc" required>
                </div>

                <div class="form-field form-field--full">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" required>
                </div>

                <div class="form-field">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                </div>
            </div>

            <footer class="form-actions">
                <a class="btn btn--secondary" href="/alunos/lista">Cancelar</a>
                <button class="btn" type="submit">Cadastrar aluno</button>
            </footer>
        </form>
    </div>
@endsection
