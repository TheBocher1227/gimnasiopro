@extends('layouts.app')

@section('title', 'Inicio - Gimnasio Pro')

@section('styles')
<style>
    .home-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
        display: flex;
        flex-direction: column;
    }

    /* Navbar */
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 40px;
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .navbar-logo {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-logo svg {
        width: 22px;
        height: 22px;
        color: white;
    }

    .navbar-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #f8fafc;
        letter-spacing: -0.01em;
    }

    .navbar-user {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .user-info {
        text-align: right;
    }

    .user-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #e2e8f0;
    }

    .user-role {
        font-size: 0.75rem;
        color: #818cf8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-logout {
        padding: 10px 20px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #f87171;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.4);
        transform: translateY(-1px);
    }

    .btn-logout svg {
        width: 18px;
        height: 18px;
    }

    /* Contenido principal */
    .main-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .welcome-card {
        text-align: center;
        animation: fadeIn 0.6s ease-out forwards;
    }

    .welcome-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 28px;
        box-shadow: 0 12px 40px rgba(99, 102, 241, 0.3);
    }

    .welcome-avatar svg {
        width: 48px;
        height: 48px;
        color: white;
    }

    .welcome-heading {
        font-size: 2.5rem;
        font-weight: 800;
        color: #f8fafc;
        margin-bottom: 12px;
        letter-spacing: -0.03em;
    }

    .welcome-sub {
        font-size: 1.1rem;
        color: #94a3b8;
        font-weight: 400;
    }

    .role-badge {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 20px;
        color: #a5b4fc;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 20px;
    }

    @media (max-width: 640px) {
        .navbar {
            padding: 16px 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .welcome-heading {
            font-size: 1.8rem;
        }

        .main-content {
            padding: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="home-wrapper">
    {{-- Navbar --}}
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="navbar-logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                </svg>
            </div>
            <span class="navbar-title">Gimnasio Pro</span>
        </a>

        <div class="navbar-user">
            @auth
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->nombre }}</div>
                    <div class="user-role">{{ Auth::user()->rol }}</div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Salir
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    {{-- Contenido --}}
    <div class="main-content">
        <div class="welcome-card">
            <div class="welcome-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>

            @auth
                <h1 class="welcome-heading">Hola, {{ Auth::user()->nombre }}</h1>
                <p class="welcome-sub">Has iniciado sesión como <strong>{{ Auth::user()->username }}</strong></p>
                <span class="role-badge">{{ Auth::user()->rol }}</span>
            @endauth
        </div>
    </div>
</div>
@endsection
