<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>

<body>
    <header>
        @yield('header')
    </header>
    <main>
        @yield('main')
    </main>
    <footer>
        <p>Leia+ © 2026 - Todos os direitos reservados</p>
        <h2>Contatos</h2>
        <a href="mailto:contato@leia.com" target="_blank">E-mail</a>
        <a href="https://www.instagram.com" target="_blank">Instagram</a>
        <a href="https://www.facebook.com" target="_blank">Facebook</a>
    </footer>
</body>

</html>
