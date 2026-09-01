<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gestión de cuentas')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header class="site-header">
        <nav class="navigation" aria-label="Navegación principal">
            <a class="brand" href="{{ route('inicio') }}">Cuentas</a>
            <div class="navigation-links">
                <a href="{{ route('cuentas.create') }}">Crear cuenta</a>
                <a href="{{ route('cuentas.index') }}">Listar cuentas</a>
            </div>
        </nav>
    </header>

    <main class="page-container">
        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
