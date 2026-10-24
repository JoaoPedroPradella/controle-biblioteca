<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use App\Models\Livro;
use App\Models\Exemplare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;


class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $busca = request('busca');
        $filtros = request()->validate([
            'status' => ['nullable', 'in:ativo,atrasado,devolvido'],
            'data_inicial' => ['nullable', 'date'],
            'data_final' => ['nullable', 'date'],
        ]);
        $status = $filtros['status'] ?? null;
        $dataInicial = $filtros['data_inicial'] ?? null;
        $dataFinal = $filtros['data_final'] ?? null;
        $aluno = Auth::user()->aluno;

        $query = Emprestimo::with('aluno.user', 'user', 'exemplar.livro');

        // Alunos veem somente os próprios empréstimos; administradores veem todos.
        if ($aluno) {
            $query->where('aluno_id', $aluno->id);
        }

        $emprestimos = $query
            ->when($busca, function ($query, $busca) {
                $termo = '%' . $busca . '%';

                $query->where(function ($query) use ($termo) {
                    $query->whereHas('exemplar.livro', function ($query) use ($termo) {
                        $query->where('titulo', 'like', $termo);
                    })
                        ->orWhereHas('aluno.user', function ($query) use ($termo) {
                            $query->where('name', 'like', $termo);
                        })
                        ->orWhereHas('exemplar', function ($query) use ($termo) {
                            $query->where('codigo_patrimonio', 'like', $termo);
                        });
                });
            })
            ->when($status, function ($query, $status) {
                match ($status) {
                    'ativo' => $query
                        ->whereNull('data_dev')
                        ->whereDate('data_prev_dev', '>=', today()),
                    'atrasado' => $query
                        ->whereNull('data_dev')
                        ->whereDate('data_prev_dev', '<', today()),
                    'devolvido' => $query->whereNotNull('data_dev'),
                };
            })
            ->when($dataInicial, function ($query, $dataInicial) {
                $query->whereDate('data_retirada', '>=', $dataInicial);
            })
            ->when($dataFinal, function ($query, $dataFinal) {
                $query->whereDate('data_retirada', '<=', $dataFinal);
            })
            ->get();

        return view('emprestimos/index', compact(
            'emprestimos',
            'busca',
            'status',
            'dataInicial',
            'dataFinal'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emprestimos/create');
    }

    // Pesquisa de livros para a view de criação de empréstimos
    public function buscarLivros(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
        ]);

        $livros = Livro::query()
            ->where('titulo', 'like', '%' . $request->titulo . '%')
            ->where('ativo', true)
            ->with([
                'exemplares' => function ($query) {
                    $query->where('status', 'disponivel');
                }
            ])
            ->limit(10)
            ->get();

        return response()->json($livros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $emprestimo = new Emprestimo;

        $request->validate([
            'exemplares' => 'required|json',
        ]);

        $idExemplares = json_decode($request->input('exemplares'), true);


        if (!is_array($idExemplares) || count($idExemplares) === 0) {
            return redirect('/emprestimo/cadastrar')->with('msg', 'Selecione pelo menos um exemplar!');
        }

        // Converte o request de JSON para um array, assim podemos trabalhar com o request 
        $request->merge(['exemplares' => $idExemplares]);

        // Com o validate ele retorna automaticamente para a tela de cadastro caso encontre uma falha
        $request->validate([
            'exemplares' => 'required|array|min:1',
            'exemplares.*' => 'required|integer|distinct|exists:exemplares,id',
        ]);


        Log::info('Dados', [
            'idsExemplares' => ($idExemplares),
        ]);

        // whereIn para consultar um array no bd

        DB::transaction(function () use ($idExemplares, $emprestimo) {
            $exemplares = Exemplare::query()
                ->whereIn('id', $idExemplares)
                ->lockForUpdate()
                ->get();

            // Verifica se todos os IDs foram encontrados
            if ($exemplares->count() !== count($idExemplares)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'exemplares' => 'Um ou mais exemplares não existem.',
                ]);
            }

            // Verifica se todos estão disponíveis
            if ($exemplares->contains(fn($exemplar) => $exemplar->status !== 'disponivel')) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'exemplares' => 'Um ou mais exemplares não estão disponíveis.',
                ]);
            }
            foreach ($exemplares as $exemplar) {
                $emprestimo->create([
                    'aluno_id' => Auth::user()->aluno->id,
                    'user_id' => Auth::user()->id,
                    'exemplar_id' => $exemplar->id,
                    'data_retirada' => now()->toDateString(),
                    'data_prev_dev' => now()->addDays(7)->toDateString()

                ]);

                $exemplar->update([
                    'status' => 'emprestado'
                ]);
            }
        });

        return redirect('/emprestimos/lista')->with('msg', 'Emprestimo cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function devolver(string $id)
    {
        $dados = Validator::make(
            ['exemplar_id' => $id],
            ['exemplar_id' => ['required', 'integer', 'exists:exemplares,id']]
        )->validate();

        $emprestimo = Emprestimo::where('exemplar_id', $dados['exemplar_id'])
            ->whereNull('data_dev')
            ->firstOrFail();


        $exemplar = Exemplare::findOrFail($dados['exemplar_id']);

        try {
            $emprestimo->update([
                'data_dev' => now()->toDateString(),
            ]);

            $exemplar->update([
                'status' => "disponivel",
            ]);

            return redirect('/emprestimos/lista')->with('msg', 'Livro devolvido com sucesso!');
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return redirect('/emprestimos/lista')->withErrors([
                'erro' => 'Não foi possível concluir o empréstimo.',
            ]);
        }
    }
}
