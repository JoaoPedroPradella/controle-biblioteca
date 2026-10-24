@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <button type="button" onclick="history.back()" aria-label="Voltar">&larr;</button>
    <h1>Editando o livro {{ $livro->titulo }}</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    <form action="/livro/update/{{ $livro->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" id="titulo" required value="{{ $livro->titulo }}"><br>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" required value="{{ $livro->autor }}"><br>

        <label for="editora">Editora:</label>
        <input type="text" name="editora" id="editora" required value="{{ $livro->editora }}"><br>

        <label for="data_publicacao">Data de publicação:</label>
        <input type="date" name="data_pub" id="data_pub" required
            value="{{ date('Y-m-d', strtotime($livro->data_pub)) }}"><br>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero" required value="{{ $livro->genero }}"><br>

        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" id="idioma" required value="{{ $livro->idioma }}"><br>

        <label for="qtd_pag">Quantidade de páginas:</label>
        <input type="number" min="1" name="qtd_pag" id="qtd_pag" required value="{{ $livro->qtd_pag }}"><br>

        <div>
            <label for="tipo_capa">Tipo da Capa:</label>
            <select name="tipo_capa" id="tipo_capa" required>
                <option value="capa_dura">Capa Dura</option>
                <option value="brochura" {{ $livro->tipo_capa == 'brochura' ? "selected='selected'" : '' }}>Brochura
                </option>
            </select>
        </div>

        <div>
            <label for="sinopse">Sinopse:</label>
        </div>
        <textarea name="sinopse" id="sinopse" rows="4" cols="50">{{ $livro->sinopse }}</textarea><br>

        <label for="imagem">Imagem do Livro:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*"><br>
        <div>
            @if ($livro->imagem)
                <img src="/img/livros/{{ $livro->imagem }}" alt="Imagem do Livro {{ $livro->titulo }}" width="200">
            @else
                <p>Sem imagem</p>
            @endif
        </div>


        @if ($livro->exemplares->isEmpty())
            <p>Não há exemplares cadastrados para este livro.</p>
        @else
            @foreach ($livro->exemplares as $exemplar)
                <li>{{ $exemplar->codigo_patrimonio }} - Status: {{ $exemplar->status }}</li>
                <li>Exemplar {{ $loop->iteration }}</li>

                {{-- O controller recebe o name e o value do select, e atualiza o status do exemplar com o id correspondente --}}
                <select name="status_exemplares[{{ $exemplar->id }}]" id="status_{{ $exemplar->id }}">
                    @foreach ([
            'disponivel' => 'Disponível', // Validar para não alterar caso o exemplar esteja emprestado, reservado ou danificado
            'danificado' => 'Danificado',
            'perdido' => 'Perdido',
            'bloqueado' => 'Bloqueado',
            'baixado' => 'Baixado',
        ] as $valor => $descricao)
                        // Envia o valor ao controller, o valor é a coluna esquerda, enquanto a coluna direita é a descrição
                        @if ($exemplar->status == 'emprestado')
                            <option value="emprestado" @selected('emprestado') disabled>emprestado</option>
                        @else
                            <option value="{{ $valor }}" @selected($exemplar->status === $valor)>
                                {{ $descricao }}
                            </option>
                        @endif
                    @endforeach
                </select>
            @endforeach

        @endif

        <input type="submit" value="Editar">
    </form>

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
