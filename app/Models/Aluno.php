<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Aluno extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
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
