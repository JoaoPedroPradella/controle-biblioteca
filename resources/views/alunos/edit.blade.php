@extends('layouts.main')

@section('title', 'Editar aluno')

@section('header')
    <h1>Editar aluno</h1>
@endsection

@section('main')
    <div class="form-page">
        <a class="content-back-link" href="/aluno/{{ $aluno->id }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
            Voltar para detalhes
        </a>

        <form class="form-card" action="/aluno/update/{{ $aluno->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <header>
                <h2>Dados do aluno</h2>
                <p>As alterações serão salvas no cadastro existente.</p>
            </header>

            <div class="form-grid">
                <div class="form-field form-field--full">
                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" required value="{{ $usuario->name }}">
                </div>

                <div class="form-field">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" required value="{{ $aluno->cpf }}">
                </div>

                <div class="form-field">
                    <label for="data_nasc">Data de nascimento</label>
                    <input type="date" name="data_nasc" id="data_nasc" required value="{{ date('Y-m-d', strtotime($aluno->data_nasc)) }}">
                </div>

                <div class="form-field form-field--full">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" required value="{{ $usuario->email }}">
                </div>
            </div>

            <footer class="form-actions">
                <a class="btn btn--secondary" href="/aluno/{{ $aluno->id }}">Cancelar</a>
                <button class="btn" type="submit">Salvar alterações</button>
            </footer>
        </form>
    </div>
@endsection
