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
        Schema::create('exemplares', function (Blueprint $table) {
            $table->id();

            $table->foreignId('livro_id')
                ->constrained('livros')
                ->cascadeOnDelete();

            $table->string('codigo_patrimonio')->nullable()->unique();;

            // Status	            Significado
            // disponivel	        Pode ser emprestado, se o livro estiver ativo
            // emprestado	        Está com um aluno
            // danificado	        Não pode ser emprestado por problemas físicos
            // perdido	            Não foi localizado
            // baixado	            Retirado definitivamente do acervo
            // bloqueado	        Temporariamente impedido de ser emprestado
            $table->enum('status', [
                'disponivel',
                'emprestado',
                'danificado',
                'perdido',
                'baixado',
                'bloqueado'
            ])->default('disponivel');

            // Situação	Mensagem
            // Todos os exemplares estão emprestados	                                Nenhum exemplar disponível para empréstimo.
            // O livro está inativo	                                                    Este livro está inativo e não pode ser emprestado.
            // Os exemplares estão baixados, perdidos ou danificados	                Não há exemplares aptos para empréstimo.
            // O exemplar selecionado deixou de estar disponível	                    A disponibilidade foi alterada. Atualize a seleção e tente novamente.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exemplares');
    }
};
