<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    // O HasFactory é usado para preenchimento de dados de teste, usados no arquivo database/factories/LivroFactory.php
    use HasFactory;
    // Com essa linha, o Laravel não tentará atualizar os campos created_at e updated_at na tabela livros, já que não existem esses campos na tabela.
    public $timestamps = false;
    protected $dates = ['date'];
}
