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
        Schema::create('exemplares_emprestimos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_emprestimo')->constrained('emprestimos');
            $table->foreignId('id_exemplar')->constrained('exemplares');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exemplares_emprestimos');
    }
};
