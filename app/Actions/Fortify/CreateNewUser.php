<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            
            // O Laravel preenche automaticamente o campo user_id na tabela alunos com o ID do usuário, por conta do relacionamento definido no model User. Para isso usamos o comando "$user->aluno()->create".
            $user->aluno()->create([
                'matricula' => random_int(100000, 999999),
                'cpf' => $input['cpf'],
                'data_nasc' => $input['data_nasc'],
            ]);

            return $user;
        });
    }
}
