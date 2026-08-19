<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>@yield('title', 'Online Store')</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary py-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home.index') }}">Online Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavigation">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link {{ request()->routeIs('home.index') ? 'active' : '' }}" href="{{ route('home.index') }}">Home</a>
                    <a class="nav-link {{ request()->routeIs('home.about') ? 'active' : '' }}" href="{{ route('home.about') }}">About</a>
                    <a class="nav-link {{ request()->routeIs('home.contact') ? 'active' : '' }}" href="{{ route('home.contact') }}">Contact</a>
                    <a class="nav-link {{ request()->routeIs('product.index', 'product.show') ? 'active' : '' }}" href="{{ route('product.index') }}">Products</a>
                    <a class="nav-link {{ request()->routeIs('product.create') ? 'active' : '' }}" href="{{ route('product.create') }}">Create Products</a>
                </div>
            </div>
        </div>
    </nav>

    <header class="masthead bg-primary text-white text-center py-4">
        <div class="container d-flex align-items-center flex-column">
            <h2>@yield('subtitle', 'A Laravel EAFIT App')</h2>
        </div>
    </header>

    <main class="container my-4 flex-grow-1">@yield('content')</main>

    <footer class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; {{ date('Y') }} - Isabela Ruiz de la Ossa</small></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
