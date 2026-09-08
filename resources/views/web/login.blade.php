@extends('template.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/web/auth.css') }}">
@endsection

@section('title','Login')

@section('content')
<div class="login-container">

    <div class="card p-4 shadow login-box">
        <h3 class="text-center mb-4">Login Admin</h3>

        @if ($errors->any())
            <p class="text-danger mb-3">Erro ao fazer login. Verifique suas credenciais.</p>
        @endif
        <form action="{{ route('login.authenticate') }}" method="POST">
             @csrf

            <input
                type="email"
                name="email"
                class="form-control mb-3"
                placeholder="Email"
                value="{{ old('email') }}"
                required
            >

            <input
                type="password"
                name="password"
                class="form-control mb-3"
                placeholder="Senha"
                required
            >

            <button type="submit" class="btn btn-warning w-100">
                Entrar
            </button>
        </form>

    </div>

</div>
@endsection