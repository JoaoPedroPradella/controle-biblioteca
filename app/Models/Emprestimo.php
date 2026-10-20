<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Emprestimo extends Model
{
    //
    public $timestamps = false;

    // Define como o Laravel deve converter atributos do banco ao ler e salvar dados no Model.
    protected $casts = [
        'data_retirada' => 'date',
        'data_prev_dev' => 'date',
        'data_dev' => 'date',
    ];

    // fillable permite enviar vários dados de uma vez para o banco de dados, usando um array associativo, sem precisar setar cada atributo individualmente.
    protected $fillable = [
        'user_id',
        'matricula',
        'cpf',
        'data_nasc',
    ];

    // Indica que um Aluno pertence a um Usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
