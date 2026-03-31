<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gimnasio Pro')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Notyf CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #f5f5f7;
            color: #111827;
            -webkit-font-smoothing: antialiased;
        }

        /* ---- Loader Overlay ---- */
        .loader-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .loader-overlay.active {
            display: flex;
        }

        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #e5e7eb;
            border-top-color: #111827;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    @yield('styles')
</head>
<body>
    {{-- Loader global --}}
    <div class="loader-overlay" id="loader">
        <div class="loader-spinner"></div>
    </div>

    @yield('content')

    {{-- Notyf JS --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        // Inicializar Notyf — arriba derecha
        var notyf = new Notyf({
            duration: 3500,
            position: { x: 'right', y: 'top' },
            dismissible: true,
            ripple: true
        });

        // Loader
        function showLoader() {
            document.getElementById('loader').classList.add('active');
        }
        function hideLoader() {
            document.getElementById('loader').classList.remove('active');
        }

        // Loader automático al enviar forms
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                showLoader();
            });
        });

        // Flash messages de Laravel → Notyf
        @if (session('success'))
            notyf.success({!! json_encode(session('success')) !!});
        @endif

        @if (session('error'))
            notyf.error({!! json_encode(session('error')) !!});
        @endif
    </script>

    @yield('scripts')
</body>
</html>
