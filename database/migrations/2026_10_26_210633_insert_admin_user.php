<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'adm@biblioteca.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456'),
                'type' => 'admin',
                'situation' => 'ativo',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('users')
            ->where('email', 'adm@biblioteca.com')
            ->delete();
    }
};
