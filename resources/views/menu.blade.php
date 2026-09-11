{{-- Script para não permitir o usuário voltar a página do navegador, uma vez que está logado ele precisa usar a função de sair --}}
<script>
    window.history.pushState(null, '', window.location.href);

    window.addEventListener('popstate', function() {
        window.history.pushState(null, '', window.location.href);
        window.location.reload();
    });
</script>

@extends('layouts.main')

@section('title', 'Leia+')

@section('header')
    <h1>Menu Leia+</h1>
    {{-- Usado auth para validar se está logado --}}
    @auth
        <form action="/logout" method="POST">
            @csrf
            <a href="/auth/login" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
        </form>
    @endauth
    {{-- Usado guest para validar se está deslogado --}}
    @guest
        <nav>
            <a href="/auth/login"><button>Entrar</button></a>
            <a href="/auth/register"><button>Cadastrar</button></a>
        </nav>
    @endguest

@endsection
@section('main')
    <a href="/alunos/lista"><button>Alunos</button></a>
    <a href="/livros/lista"><button>Livros</button></a>
    <a href="/emprestimos/lista"><button>Empréstimos</button></a>
    <a href="/usuarios/lista"><button>Usuários</button></a>
@endsection
@section('footer')
