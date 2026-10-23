<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use App\Models\Livro;
use App\Models\Exemplare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Depoi vou implementar as buscas aqui, mas por enquanto vou apenas retornar todos os emprestimos

        // Filtro para trazer os emprestimos do usuário logado, caso ele seja um aluno. Se for um ADM, traz todos os emprestimos
        // ?? quer dizer null, então se o valor for null use false
        if (Auth::user()->aluno->id ?? false) {
            $id_user_logado = Auth::user()->aluno->id;
            $emprestimos = Emprestimo::with('aluno.user', 'user', 'exemplar.livro')->where('aluno_id', $id_user_logado)->get();
        } else {
            $id_user_logado = Auth::user()->id;
            $emprestimos = Emprestimo::with('aluno.user', 'user', 'exemplar.livro')->get();
        };

        return view('emprestimos/index', ['emprestimos' => $emprestimos]);
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
}
