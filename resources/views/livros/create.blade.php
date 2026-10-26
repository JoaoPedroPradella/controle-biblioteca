@extends('layouts.main')

@section('title', 'Novo livro')

@section('header')
    <h1>Novo livro</h1>
@endsection

@section('main')
    <div class="form-page">
        <a class="content-back-link" href="/livros/lista">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
            Voltar para livros
        </a>

        <form class="form-card" action="/livros" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-grid">
                <div class="form-field form-field--full"><label for="titulo">Título</label><input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required></div>
                <div class="form-field"><label for="autor">Autor</label><input type="text" name="autor" id="autor" value="{{ old('autor') }}" required></div>
                <div class="form-field"><label for="editora">Editora</label><input type="text" name="editora" id="editora" value="{{ old('editora') }}" required></div>
                <div class="form-field"><label for="isbn">ISBN</label><input type="text" name="isbn" id="isbn" maxlength="13" value="{{ old('isbn') }}" required></div>
                <div class="form-field"><label for="data_pub">Data de publicação</label><input type="date" name="data_pub" id="data_pub" value="{{ old('data_pub') }}" required></div>
                <div class="form-field"><label for="genero">Gênero</label><input type="text" name="genero" id="genero" value="{{ old('genero') }}" required></div>
                <div class="form-field"><label for="idioma">Idioma</label><input type="text" name="idioma" id="idioma" value="{{ old('idioma') }}" required></div>
                <div class="form-field"><label for="qtd_pag">Quantidade de páginas</label><input type="number" min="1" name="qtd_pag" id="qtd_pag" value="{{ old('qtd_pag') }}" required></div>
                <div class="form-field"><label for="qtd_exemp">Quantidade de exemplares</label><input type="number" min="1" name="qtd_exemp" id="qtd_exemp" value="{{ old('qtd_exemp') }}" required></div>
                <div class="form-field"><label for="tipo_capa">Tipo de capa</label><select name="tipo_capa" id="tipo_capa" required><option value="capa_dura" @selected(old('tipo_capa') === 'capa_dura')>Capa dura</option><option value="brochura" @selected(old('tipo_capa') === 'brochura')>Brochura</option></select></div>
                <div class="form-field"><label for="imagem">Imagem do livro</label><input type="file" name="imagem" id="imagem" accept="image/*"></div>
                <div class="form-field form-field--full"><label for="sinopse">Sinopse</label><textarea name="sinopse" id="sinopse">{{ old('sinopse') }}</textarea></div>
            </div>
            <footer class="form-actions"><a class="btn btn--secondary" href="/livros/lista">Cancelar</a><button class="btn" type="submit">Cadastrar livro</button></footer>
        </form>
    </div>

@endsection
