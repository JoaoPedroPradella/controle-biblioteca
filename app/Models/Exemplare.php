<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Livro;


class Exemplare extends Model
{
    public function livro()
    {
        return $this->belongsTo(Livro::class);
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
