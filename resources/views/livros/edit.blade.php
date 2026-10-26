@extends('layouts.main')

@section('title', 'Editar livro')

@section('header')
    <h1>Editar livro</h1>
@endsection

@section('main')
    <div class="form-page">
        <a class="content-back-link" href="/livro/{{ $livro->id }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>Voltar para detalhes</a>
        <form class="form-card" action="/livro/update/{{ $livro->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="form-grid">
                <div class="form-field form-field--full"><label for="titulo">Título</label><input type="text" name="titulo" id="titulo" required value="{{ old('titulo', $livro->titulo) }}"></div>
                <div class="form-field"><label for="autor">Autor</label><input type="text" name="autor" id="autor" required value="{{ old('autor', $livro->autor) }}"></div>
                <div class="form-field"><label for="editora">Editora</label><input type="text" name="editora" id="editora" required value="{{ old('editora', $livro->editora) }}"></div>
                <div class="form-field"><label for="data_pub">Data de publicação</label><input type="date" name="data_pub" id="data_pub" required value="{{ old('data_pub', date('Y-m-d', strtotime($livro->data_pub))) }}"></div>
                <div class="form-field"><label for="genero">Gênero</label><input type="text" name="genero" id="genero" required value="{{ old('genero', $livro->genero) }}"></div>
                <div class="form-field"><label for="idioma">Idioma</label><input type="text" name="idioma" id="idioma" required value="{{ old('idioma', $livro->idioma) }}"></div>
                <div class="form-field"><label for="qtd_pag">Quantidade de páginas</label><input type="number" min="1" name="qtd_pag" id="qtd_pag" required value="{{ old('qtd_pag', $livro->qtd_pag) }}"></div>
                <div class="form-field"><label for="tipo_capa">Tipo de capa</label><select name="tipo_capa" id="tipo_capa" required><option value="capa_dura" @selected(old('tipo_capa', $livro->tipo_capa) === 'capa_dura')>Capa dura</option><option value="brochura" @selected(old('tipo_capa', $livro->tipo_capa) === 'brochura')>Brochura</option></select></div>
                <div class="form-field"><label for="imagem">Nova imagem</label><input type="file" name="imagem" id="imagem" accept="image/*">@if ($livro->imagem)<div class="image-preview"><img src="/img/livros/{{ $livro->imagem }}" alt="Capa atual"><span>Imagem atual do livro</span></div>@endif</div>
                <div class="form-field form-field--full"><label for="sinopse">Sinopse</label><textarea name="sinopse" id="sinopse">{{ old('sinopse', $livro->sinopse) }}</textarea></div>

                <section class="form-subsection">
                    <h3>Exemplares</h3>
                    @if ($livro->exemplares->isEmpty())
                        <p class="directory-muted">Não há exemplares cadastrados para este livro.</p>
                    @else
                        <div class="exemplar-editor">
                            @foreach ($livro->exemplares as $exemplar)
                                <div class="exemplar-editor-row">
                                    <div><strong>{{ $exemplar->codigo_patrimonio }}</strong><span>Exemplar {{ $loop->iteration }} · Status atual: {{ ucfirst($exemplar->status) }}</span></div>
                                    <select name="status_exemplares[{{ $exemplar->id }}]" id="status_{{ $exemplar->id }}" @disabled($exemplar->status === 'emprestado')>
                                        @if ($exemplar->status === 'emprestado')
                                            <option value="emprestado" selected>Emprestado</option>
                                        @else
                                            @foreach (['disponivel' => 'Disponível', 'danificado' => 'Danificado', 'perdido' => 'Perdido', 'bloqueado' => 'Bloqueado', 'baixado' => 'Baixado'] as $valor => $descricao)
                                                <option value="{{ $valor }}" @selected($exemplar->status === $valor)>{{ $descricao }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>
            <footer class="form-actions"><a class="btn btn--secondary" href="/livro/{{ $livro->id }}">Cancelar</a><button class="btn" type="submit">Salvar alterações</button></footer>
        </form>
    </div>

@endsection


@section('scripts')
    <script>
        // $('select[name^="status_exemplares"]').each(function() {
        //     if ($(this).val() === 'emprestado') {
        //         $(this).prop('disabled', true);
        //     }
        // });
    </script>
@endsection
