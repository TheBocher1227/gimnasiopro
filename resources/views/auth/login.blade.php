@extends('layouts.app')

@section('title', 'Login - Gimnasio Pro')

@section('styles')
<style>
    body {
        background: #f5f5f7;
    }

    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        background: #fff;
        border-radius: 16px;
        padding: 40px 36px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        animation: fadeUp 0.4s ease forwards;
        opacity: 0;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }

    .login-header p {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    /* Alerta de error */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error svg {
        width: 18px;
        height: 18px;
        color: #ef4444;
        flex-shrink: 0;
    }

    .alert-error span {
        color: #dc2626;
        font-size: 0.82rem;
        font-weight: 500;
    }

    /* Formulario */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-input {
        width: 100%;
        padding: 11px 14px;
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        color: #111827;
        font-size: 0.9rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    .form-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-input.is-invalid {
        border-color: #f87171;
    }

    .form-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .field-error {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 5px;
        font-weight: 500;
    }

    /* Password */
    .pw-wrap {
        position: relative;
    }

    .pw-wrap .form-input {
        padding-right: 42px;
    }

    .pw-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 2px;
        display: flex;
        transition: color 0.2s;
    }

    .pw-toggle:hover {
        color: #6b7280;
    }

    .pw-toggle svg {
        width: 18px;
        height: 18px;
    }

    /* Botón */
    .btn-login {
        width: 100%;
        padding: 12px;
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        margin-top: 8px;
    }

    .btn-login:hover {
        background: #1f2937;
    }

    .btn-login:active {
        transform: scale(0.98);
    }

    /* Footer */
    .login-footer {
        text-align: center;
        margin-top: 28px;
        color: #d1d5db;
        font-size: 0.75rem;
    }
</style>
@endsection

@section('content')
<div class="login-page">
    <div class="login-card">
        <div class="login-header">
            <h1>Gimnasio Pro</h1>
            <p>Ingresa tus credenciales para continuar</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="username" class="form-label">Usuario</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-input @error('username') is-invalid @enderror"
                    placeholder="admin"
                    value="{{ old('username') }}"
                    autofocus
                    required
                >
                @error('username')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="pw-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                    >
                    <button type="button" class="pw-toggle" onclick="togglePw()">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>

        <div class="login-footer">
            Gimnasio Pro &copy; {{ date('Y') }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePw() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />';
        }
    }
</script>
@endsection
