<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Biblioteca')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="app-body">
    @php
        $usuarioAutenticado = Auth::user();
        $ehAluno = (bool) $usuarioAutenticado?->aluno;
        $nomeUsuario = $usuarioAutenticado?->name ?? 'Usuário';
        $inicialUsuario = strtoupper(substr($nomeUsuario, 0, 1));
    @endphp

    <div id="library-ui" class="app-shell">
        <header class="app-topbar">
            <a class="brand" href="/menu" aria-label="Ir para o início">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M4 7.5c4.8-2.7 9.2-1.3 12 1.4v17.1c-2.8-2.7-7.2-4.1-12-1.4V7.5Z" fill="currentColor" />
                        <path d="M28 7.5c-4.8-2.7-9.2-1.3-12 1.4v17.1c2.8-2.7 7.2-4.1 12-1.4V7.5Z" fill="currentColor" opacity=".72" />
                    </svg>
                </span>
                <span>Biblioteca</span>
            </a>

            <div class="topbar-user">
                @auth
                    <button class="profile-trigger" type="button" data-profile-toggle aria-expanded="false">
                        <span class="profile-avatar">{{ $inicialUsuario }}</span>
                        <span class="profile-name">{{ $nomeUsuario }}</span>
                        <svg class="chevron" viewBox="0 0 24 24" aria-hidden="true"><path d="m7 10 5 5 5-5" /></svg>
                    </button>

                    <div class="profile-menu" data-profile-menu>
                        <p>{{ $nomeUsuario }}</p>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit">Sair</button>
                        </form>
                    </div>
                @endauth

                <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-expanded="false" aria-label="Abrir menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </header>

        <div class="app-frame">
            <aside class="app-sidebar" data-sidebar aria-label="Navegação principal">
                <nav class="sidebar-nav">
                    <a class="sidebar-link {{ request()->is('menu') ? 'is-active' : '' }}" href="/menu">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z" /></svg><span>Início</span>
                    </a>
                    <a class="sidebar-link {{ request()->is('livro*') ? 'is-active' : '' }}" href="/livros/lista">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11v16H6.5A2.5 2.5 0 0 0 4 21V5.5ZM20 5.5A2.5 2.5 0 0 0 17.5 3H13v16h4.5A2.5 2.5 0 0 1 20 21V5.5Z" /></svg><span>Livros</span>
                    </a>
                    <a class="sidebar-link {{ request()->is('emprestimo*') ? 'is-active' : '' }}" href="/emprestimos/lista">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 7h11m0 0-3-3m3 3-3 3M17 17H6m0 0 3 3m-3-3 3-3" /><path d="M4 4v6m0 4v6" /></svg><span>Empréstimos</span>
                    </a>
                    @if (!$ehAluno)
                        <a class="sidebar-link {{ request()->is('aluno*') ? 'is-active' : '' }}" href="/alunos/lista">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3" /><path d="M3 20c.7-3.3 2.7-5 6-5s5.3 1.7 6 5M16 5.5a3 3 0 0 1 0 5.7M17 15c2.3.3 3.7 2 4 5" /></svg><span>Alunos</span>
                        </a>
                        <a class="sidebar-link {{ request()->is('usuario*') ? 'is-active' : '' }}" href="/usuarios/lista">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3" /><path d="M5 20c.8-3.5 3.1-5.5 7-5.5s6.2 2 7 5.5" /></svg><span>Usuários</span>
                        </a>
                    @endif
                </nav>

                <div class="sidebar-footer"><span class="sidebar-status"></span>Sistema da Biblioteca</div>
            </aside>

            <button class="sidebar-backdrop" type="button" data-sidebar-backdrop hidden aria-label="Fechar menu"></button>

            <main class="app-content">
                <div class="page-heading">
                    <div class="page-heading-copy">@yield('header')</div>
                    <div class="page-heading-actions">@yield('page-actions')</div>
                </div>

                @if (session('msg'))
                    <div class="flash-message" role="status"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>{{ session('msg') }}</div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="flash-message flash-message--error" role="alert">{{ $errors->first() }}</div>
                @endif

                @yield('main')
            </main>
        </div>

        <footer class="app-footer"><span>Biblioteca © {{ date('Y') }}</span><span>Gestão simples do seu acervo.</span></footer>
    </div>

    <div id="library-vue-ui" hidden aria-hidden="true"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
</body>

</html>
