<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('exemplar_id')->constrained('exemplares');
            $table->date('data_retirada');
            // data_prev_dev: data prevista para devolução
            $table->date('data_prev_dev');
            $table->date('data_dev')->nullable();
            $table->float('multa', 10, 2)->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
