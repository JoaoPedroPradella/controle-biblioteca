<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Exemplare;


class Emprestimo extends Model
{
    // Indica que um Aluno pertence a um Usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function exemplar()
    {
        return $this->belongsTo(Exemplare::class);
    }


    //
    public $timestamps = false;

    // Define como o Laravel deve converter atributos do banco ao ler e salvar dados no Model.
    protected $casts = [
        'data_retirada' => 'date',
        'data_prev_dev' => 'date',
        'data_dev' => 'date',
    ];

    // Guarded é o oposto de fillable, ou seja, tudo que estiver nessa lista não poderá ser atualizado via POST, e os demais campos poderão ser atualizados.
    protected $guarded = [];
}
