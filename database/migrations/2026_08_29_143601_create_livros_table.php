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
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 200);
            $table->string('autor', 100);
            $table->string('editora', 150);
            $table->string('isbn', 13);
            $table->date('data_pub');
            $table->string('genero', 100);
            $table->string('idioma', 100);
            $table->unsignedInteger('qtd_pag');
            $table->enum('tipo_capa', ['brochura', 'capa_dura'])->nullable();
            $table->text('sinopse')->nullable();
            $table->boolean('ativo')->default(true);
            // Grava automaticamente os campos created_at e updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
