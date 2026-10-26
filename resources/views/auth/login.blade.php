<x-guest-layout>
    @auth
        <script>window.location.replace('/menu');</script>
    @else
        <main class="auth-content">
            <a class="auth-logo" href="/" aria-label="Biblioteca">
                <svg viewBox="0 0 32 32" fill="none" aria-hidden="true">
                    <path d="M4 7.5c4.8-2.7 9.2-1.3 12 1.4v17.1c-2.8-2.7-7.2-4.1-12-1.4V7.5Z" fill="currentColor" />
                    <path d="M28 7.5c-4.8-2.7-9.2-1.3-12 1.4v17.1c2.8-2.7 7.2-4.1 12-1.4V7.5Z" fill="currentColor" opacity=".72" />
                </svg>
            </a>

            <section class="login-card" aria-label="Acesso ao sistema">
                <header class="login-card-heading">
                    <h1>Bem-vindo de volta</h1>
                    <p>Entre para acessar a Biblioteca.</p>
                </header>

                @if ($errors->any())
                    <div class="login-alert" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @session('status')
                    <div class="login-status" role="status">{{ $value }}</div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth-field">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="username" placeholder="Digite seu e-mail">
                    </div>

                    <div class="auth-field">
                        <label for="password">Senha</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="Digite sua senha">
                    </div>

                    <label class="remember-field" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember" @checked(old('remember'))>
                        <span>Lembrar-me</span>
                    </label>

                    <div class="login-actions">
                        @if (Route::has('password.request'))
                            <a class="auth-link" href="{{ route('password.request') }}">Esqueceu sua senha?</a>
                        @endif
                        <button class="login-submit" type="submit">Entrar</button>
                    </div>

                    <a class="auth-link create-account-link" href="{{ route('register') }}">Criar conta</a>
                </form>
            </section>
        </main>
    @endauth
</x-guest-layout>
