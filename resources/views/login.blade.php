@extends('layouts.main')

@section('title', 'Login')

@section('header')
    <h1>Login Leia+</h1>
@endsection
@section('main')
    <div>
        <input type="text" placeholder="Digite seu e-mail">
        <input type="password" placeholder="Digite sua senha">
    </div>
    <a href="/menu"><button>Entrar</button></a>
@endsection
@section('footer')
    <h2>Contatos</h2>
    <a href="mailto:contato@leia.com" target="_blank">E-mail</a>
    <a href="https://www.instagram.com" target="_blank">Instagram</a>
    <a href="https://www.facebook.com" target="_blank">Facebook</a>
@endsection
