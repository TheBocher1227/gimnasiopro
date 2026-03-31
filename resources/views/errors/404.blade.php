@extends('layouts.app')

@section('title', '404 - Gimnasio Pro')

@section('styles')
<style>
    .error-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        padding: 24px;
    }

    .error-card {
        text-align: center;
        max-width: 420px;
    }

    .error-code {
        font-size: 7rem;
        font-weight: 800;
        color: #111827;
        line-height: 1;
        margin-bottom: 8px;
        letter-spacing: -0.04em;
    }

    .error-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .error-text {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 28px;
        line-height: 1.5;
    }

    .error-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        transition: background 0.15s;
    }

    .error-btn:hover {
        background: #1f2937;
    }

    .error-btn svg {
        width: 18px;
        height: 18px;
    }
</style>
@endsection

@section('content')
<div class="error-page">
    <div class="error-card">
        <div class="error-code">404</div>
        <h1 class="error-title">Página no encontrada</h1>
        <p class="error-text">La página que buscas no existe o ha sido movida.</p>
        <a href="{{ url('/dashboard') }}" class="error-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Volver al inicio
        </a>
    </div>
</div>
@endsection
