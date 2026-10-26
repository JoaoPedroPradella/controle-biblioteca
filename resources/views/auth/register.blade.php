<x-guest-layout>
    <main class="auth-content auth-content--register">
        <a class="auth-logo" href="/" aria-label="+Saber">
            <svg viewBox="0 0 32 32" fill="none" aria-hidden="true">
                <path d="M4 7.5c4.8-2.7 9.2-1.3 12 1.4v17.1c-2.8-2.7-7.2-4.1-12-1.4V7.5Z" fill="currentColor" />
                <path d="M28 7.5c-4.8-2.7-9.2-1.3-12 1.4v17.1c2.8-2.7 7.2-4.1 12-1.4V7.5Z" fill="currentColor" opacity=".72" />
            </svg>
        </a>

        <section class="login-card register-card" aria-label="Cadastro de usuário">
            <header class="login-card-heading">
                <h1>Criar conta</h1>
                <p>Cadastre-se para acessar o +Saber.</p>
            </header>

            <x-validation-errors class="login-alert" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="auth-field">
                    <label for="name">Nome</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Digite seu nome">
                </div>

                <div class="auth-field">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Digite seu e-mail">
                </div>

                <div class="auth-field">
                    <label for="cpf">CPF</label>
                    <input id="cpf" type="number" name="cpf" value="{{ old('cpf') }}" min="1" required autocomplete="username" placeholder="Digite seu CPF">
                </div>

                <div class="auth-field">
                    <label for="data_nasc">Data de nascimento</label>
                    <input id="data_nasc" type="date" name="data_nasc" value="{{ old('nasc') }}" required autocomplete="username">
                </div>

                <div class="auth-field">
                    <label for="password">Senha</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Digite sua senha">
                </div>

                <div class="auth-field">
                    <label for="password_confirmation">Confirmar senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirme sua senha">
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <label class="terms-field" for="terms">
                        <input type="checkbox" name="terms" id="terms" required>
                        <span>
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </span>
                    </label>
                @endif

                <div class="login-actions register-actions">
                    <a class="auth-link" href="{{ route('login') }}">Já tem cadastro?</a>
                    <button class="login-submit" type="submit">Cadastrar</button>
                </div>
            </form>
        </section>
    </main>
</x-guest-layout>
