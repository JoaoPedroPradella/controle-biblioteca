<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Emprestimo;


class Exemplare extends Model
{
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }


    protected static function booted(): void
    {
        static::created(function (Exemplare $exemplar) {
            $exemplar->codigo_patrimonio = 'EX' . str_pad(
                (string) $exemplar->id,
                6,
                '0',
                STR_PAD_LEFT
            );

            $exemplar->saveQuietly();
        });
    }

    protected $guarded = [];
}
