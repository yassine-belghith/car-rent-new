@extends('layouts.app')

@push('styles')
<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 2rem 0;
        background-color: #f5f5f7;
    }
    .login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        padding: 3rem;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .login-card .logo-container {
        margin-bottom: 2rem;
    }
    .login-card .logo-img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }
    .login-card h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1c1c1e;
    }
    .login-card p.subtitle {
        color: #8a8a8e;
        margin-bottom: 2rem;
    }
    .form-control {
        background-color: #f5f5f7;
        border: 1px solid #e5e5e7;
        border-radius: 0.8rem;
        padding: 0.9rem 1rem;
        font-size: 1rem;
        transition: all 0.2s ease-in-out;
    }
    .form-control:focus {
        background-color: #ffffff;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
    }
    .btn-login {
        width: 100%;
        padding: 0.9rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.8rem;
        background-color: #007bff;
        border: none;
        color: white;
        transition: background-color 0.2s ease;
    }
    .btn-login:hover {
        background-color: #0056b3;
    }
    .form-check-label {
        color: #3a3a3c;
    }
    .register-link {
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: #8a8a8e;
    }
    .register-link a {
        color: #007bff;
        font-weight: 500;
        text-decoration: none;
    }
    .register-link a:hover {
        text-decoration: underline;
    }
    .alert-danger {
        border-radius: 0.8rem;
        text-align: left;
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="logo-container">
            <img src="{{ asset('assets/rent.png') }}" alt="Logo" class="logo-img">
        </div>
        <h1>Bon retour</h1>
        <p class="subtitle">Veuillez entrer vos informations pour vous connecter.</p>

        <form method="POST" action="{{ route('login.perform') }}">
            @csrf

            @error('email')
                <div class="alert alert-danger mb-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Adresse E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>

            <div class="mb-4 text-start">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                <a href="{{ route('password.request') }}" class="forgot-password-link">Mot de passe oublié ?</a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Se souvenir de moi
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">Se connecter</button>

            <p class="register-link">
                Vous n'avez pas de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a>
            </p>
        </form>
    </div>
</div>
@endsection