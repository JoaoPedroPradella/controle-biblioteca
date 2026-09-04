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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('email', 150)->unique();
            $table->string('senha', 255);
            $table->enum('tipo', ['aluno', 'admin']);
            $table->enum('situacao', ['ativo', 'inativo']);
            $table->datetime('data_cad');
            $table->datetime('data_exc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
