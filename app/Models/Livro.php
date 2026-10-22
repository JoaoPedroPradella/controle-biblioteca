<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exemplare;

class Livro extends Model
{
    public function exemplar()
    {
        return $this->hasMany(Exemplare::class);
    }

    // O HasFactory é usado para preenchimento de dados de teste, usados no arquivo database/factories/LivroFactory.php
    use HasFactory;
    // Com essa linha, o Laravel não tentará atualizar os campos created_at e updated_at na tabela livros, já que não existem esses campos na tabela.
    // public $timestamps = false;
    protected $dates = ['date'];

    // Usamos esse registro para dizer que tudo que for enviado pelo POST é passível de atualização, caso colocassemos algum campo na lista, apenas ele poderia ser atualizado, e os demais seriam ignorados.
    protected $guarded = [];
}
