{{-- Script para não permitir o usuário voltar a página do navegador, uma vez que está logado ele precisa usar a função de sair --}}
<script>
    window.history.pushState(null, '', window.location.href);

    window.addEventListener('popstate', function() {
        window.history.pushState(null, '', window.location.href);
        window.location.reload();
    });
</script>

@extends('layouts.main')

@section('title', '+Saber')

@section('header')
    <h1>Menu +Saber</h1>
    {{-- Usado guest para validar se está deslogado --}}
    @guest
        <nav>
            <a href="/auth/login"><button>Entrar</button></a>
            <a href="/auth/register"><button>Cadastrar</button></a>
        </nav>
    @endguest

@endsection
@section('main')
    @if (Auth::user()->aluno->id ?? false)
        <a href="/livros/lista"><button>Livros</button></a>
        <a href="/emprestimos/lista"><button>Empréstimos</button></a>
    @else
        <a href="/livros/lista"><button>Livros</button></a>
        <a href="/emprestimos/lista"><button>Empréstimos</button></a>
        <a href="/alunos/lista"><button>Alunos</button></a>
        <a href="/usuarios/lista"><button>Usuários</button></a>
    @endif
@endsection
@section('footer')
