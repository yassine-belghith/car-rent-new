<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .top-bar {
            background-color: #111;
            height: 8px;
        }

        .koyeb-navbar {
            background-color: #f7f7f7;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e5e5;
        }

        .koyeb-navbar .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #111 !important;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .koyeb-navbar .navbar-brand i {
            font-size: 1.8rem;
            color: #111;
            margin-right: 0.5rem;
        }

        .nav-center {
            background-color: #e9e9e9;
            border-radius: 12px;
            padding: 0.5rem;
        }

        .nav-center .nav-link {
            color: #555;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .nav-center .nav-link:hover {
            background-color: #dcdcdc;
            color: #111;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-right .login-link {
            color: #333;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .nav-right .login-link:hover {
            color: #000;
        }

        .nav-right .signup-btn {
            background-color: #222;
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .nav-right .signup-btn:hover {
            background-color: #000;
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @stack('styles')
    <style>
        /* Fix for hero section overlay blocking form interaction */
        .hero-section::before {
            pointer-events: none !important;
        }
        .booking-panel {
            pointer-events: auto !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <div class="top-bar"></div>
        <nav class="koyeb-navbar">
            <!-- Left: Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-layer-group"></i> <!-- Placeholder for Koyeb-style logo -->
                <span>Car Rent</span>
            </a>

            <!-- Center: Main Navigation -->
            <div class="nav-center d-none d-lg-flex">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item"><a href="{{ route('car.acceuil') }}" class="nav-link">Accueil</a></li>
                    <li class="nav-item"><a href="{{ route('car.cars') }}" class="nav-link">Voitures</a></li>
                    <li class="nav-item"><a href="{{ route('contact.form') }}" class="nav-link">Contact</a></li>
                </ul>
            </div>

            <!-- Right: Auth Links -->
            <div class="nav-right">
                @guest
                    @if (Route::has('login'))
                        <a class="login-link" href="{{ route('login') }}">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a class="signup-btn" href="{{ route('register') }}">Sign Up</a>
                    @endif
                @else
                    <div class="dropdown">
                        <a id="navbarDropdown" class="login-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.show') }}">Mon Profil</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Toast Container -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="toast-container" class="toast-container">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @stack('scripts')

</body>
</html>
