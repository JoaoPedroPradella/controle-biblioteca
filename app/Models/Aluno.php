<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
