@extends('layouts.main')

@section('title', 'Cadastro')

@section('header')
    <button type="button" onclick="history.back()" aria-label="Voltar">&larr;</button>
    <h1>Cadastre um Novo Livro</h1>
@endsection
@section('main')
    {{-- enctype é necessário para enviar arquivos por um form html --}}
    <form id="formEmprestimo" action="/emprestimos" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="buscarLivro" class="form-label">
            Buscar livro por título
        </label>
        <input type="text" id="buscarLivro" class="form-control" placeholder="Digite o título do livro..."
            autocomplete="off">

        <div id="resultadosLivros" class="list-group mt-2">
        </div>

        <div class="mb-3">
            <label for="exemplar_id" class="form-label">
                Exemplar disponível
            </label>

            <select id="exemplar_id" class="form-select">
                <option value="">Selecione um livro primeiro</option>
            </select>
        </div>

        {{-- Exibe a lista de livros usando JS --}}
        <ul class="list-unstyled">
        </ul>

        <button type="button" id="btnAdicionarLivro" class="btn btn-primary" onclick="adicionarLivro()">
            Adicionar livro
        </button>

        {{--  Campo oculto para enviar os IDs de emprestimos para o controller --}}
        <input type="hidden" name="exemplares" id="exemplares">

        <input type="submit" value="Cadastrar">
    </form>

@endsection

@section('scripts')
    <script>
        $(function() {

            let temporizador;

            const campoBusca = $('#buscarLivro');
            const resultados = $('#resultadosLivros');
            const selectExemplar = $('#exemplar_id');

            campoBusca.on('input', function() {

                clearTimeout(temporizador);

                const titulo = $(this).val().trim();

                resultados.empty();

                selectExemplar.empty().append(
                    $('<option>').val('').text('Selecione um livro primeiro')
                );

                if (titulo.length < 2) {
                    return;
                }

                resultados.append(
                    $('<div>')
                    .addClass('list-group-item text-muted')
                    .text('Pesquisando...')
                );

                temporizador = setTimeout(function() {

                    $.ajax({
                        url: @json(route('emprestimos.buscarLivros')),
                        method: 'GET',
                        data: {
                            titulo: titulo
                        },
                        dataType: 'json',

                        success: function(livros) {

                            resultados.empty();

                            if (livros.length === 0) {
                                resultados.append(
                                    $('<div>')
                                    .addClass('list-group-item text-muted')
                                    .text('Nenhum livro encontrado.')
                                );
                                return;
                            }

                            livros.forEach(function(livro) {

                                const disponiveis = livro.exemplares || [];
                                const indisponivel = disponiveis.length === 0;

                                const botao = $('<button>')
                                    .attr('type', 'button')
                                    .addClass(
                                        'list-group-item list-group-item-action'
                                    )
                                    .prop('disabled', indisponivel);

                                botao.append(
                                    $('<div>').text(
                                        livro.titulo + ' — ' + livro.autor
                                    )
                                );

                                if (indisponivel) {

                                    botao.addClass('text-muted bg-light');

                                    botao.append(
                                        $('<small>')
                                        .addClass('d-block mt-1')
                                        .text(
                                            'Todos os exemplares estão emprestados ou indisponíveis.'
                                        )
                                    );

                                } else {

                                    botao.append(
                                        $('<small>')
                                        .addClass(
                                            'd-block mt-1 text-success')
                                        .text(
                                            disponiveis.length +
                                            ' exemplar(es) disponível(is)'
                                        )
                                    );

                                    botao.on('click', function() {

                                        campoBusca.val(livro.titulo);
                                        resultados.empty();

                                        selectExemplar.empty().append(
                                            $('<option>')
                                            .val('')
                                            .text(
                                                'Selecione um exemplar'
                                            )
                                        );

                                        disponiveis.forEach(function(
                                            exemplar) {

                                            selectExemplar
                                                .append(
                                                    $(
                                                        '<option>'
                                                    )
                                                    .val(
                                                        exemplar
                                                        .id)
                                                    .text(
                                                        exemplar
                                                        .codigo_patrimonio
                                                    )
                                                );

                                        });
                                    });
                                }

                                resultados.append(botao);
                            });
                        },

                        error: function(xhr) {

                            resultados.empty();

                            resultados.append(
                                $('<div>')
                                .addClass('list-group-item text-danger')
                                .text('Erro ao pesquisar livros.')
                            );

                            console.error(
                                'Erro na busca:',
                                xhr.status,
                                xhr.responseText
                            );
                        }
                    });

                }, 300);
            });
        })

        // array para salvar os id de emprestimos que estão sendo salvos na listagem
        const idExemplares = [];

        function adicionarLivro() {
            const selectExemplar = $('#exemplar_id');
            const exemplarId = selectExemplar.val();
            const titulo = $('#buscarLivro');
            const exemplarText = selectExemplar.find('option:selected').text();

            if (!exemplarId) {
                alert('Selecione um exemplar antes de adicionar.');
                return;
            }

            // includes(), verifica diretamente se o valor já existe no array.
            if (!idExemplares.includes(exemplarId)) {
                idExemplares.push(exemplarId);
            } else {
                alert('Exemplar já selecionado!');
                return;
            }

            console.log(idExemplares);
            // Captura o ul no html com a classe list-unstyled
            const listaLivros = $('ul.list-unstyled');


            const novoItem = $('<li>')
                .addClass('row border-bottom py-2')
                .append(
                    $('<div>').addClass('col-md-6').text(titulo.val()),
                    $('<div>').addClass('col-md-6').text(exemplarText),
                    // attr é para definir o tipo do botão, assim o form entende que não é de submit 
                    // para passar um valor para a function precisamso fazer dessa maneira, com function() 
                    $('<button>').attr('type', 'button').addClass('col-md-6').text('Remover').on('click', function() {
                        removerItemLista(novoItem, exemplarId);
                    }),
                );

            listaLivros.append(novoItem);

            selectExemplar.val('');
        }

        function removerItemLista(item, id) {
            // Remover item da lista html
            item.remove();

            // Remover item do array
            const indice = idExemplares.indexOf(id);

            if (indice !== -1) {
                idExemplares.splice(indice, 1);
            }
        }


        // Adiciona um JSON contendo o id de exemplares no value do campo oculto
        $('#formEmprestimo').on('submit', function() {
            // console.log('chegou aqui')
            // if (idExemplares.length < 1) {
            //     alert('Adicione um exemplar para realizar o empréstimo!')
            //     return;
            // }

            $('#exemplares').val(JSON.stringify(idExemplares));
        });
    </script>
@endsection
