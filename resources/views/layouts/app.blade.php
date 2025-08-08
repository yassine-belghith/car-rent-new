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
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        .min-vh-80 {
            min-height: 80vh;
        }

        /* Custom Navbar Styling */
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s ease-in-out;
            color: #333;
            font-weight: 500;
            padding-bottom: 8px;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #007bff;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .navbar-nav .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .navbar-nav .nav-link.active {
            color: #007bff !important;
        }

        .navbar-nav .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Dropdown Animation */
        .dropdown .dropdown-menu {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: block;
            pointer-events: none;
        }

        .dropdown:hover .dropdown-menu, .dropdown.show .dropdown-menu {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f0f0f0;
        }

        .user-avatar-initials {
            background-color: #007bff !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-car"></i> CarRental
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('car.acceuil') ? 'active' : '' }}" href="{{ route('car.acceuil') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('car.cars') ? 'active' : '' }}" href="{{ route('car.cars') }}">Nos véhicules</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('contact.form') ? 'active' : '' }}" href="{{ route('contact.form') }}">Contact</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @php
                                        $user = Auth::user();
                                        $avatarUrl = $user->avatar ? asset('storage/' . ltrim($user->avatar, '/')) : '';
                                        $hasAvatar = !empty($user->avatar);
                                    @endphp
                                    @if($hasAvatar)
                                        <div class="me-2 user-avatar" 
                                             style="width: 48px; height: 48px; border-radius: 50%; background-size: cover; background-position: center; 
                                                    background-image: url('{{ $avatarUrl }}?v={{ time() }}'); 
                                                    border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                             data-avatar-url="{{ $avatarUrl }}"></div>
                                    @else
                                        <div class="me-2 d-flex align-items-center justify-content-center user-avatar-initials" style="width: 48px; height: 48px; border-radius: 50%; 
                                                    color: white; font-size: 20px; font-weight: bold; border: 2px solid #fff; 
                                                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2" aria-labelledby="navbarDropdown" style="min-width: 240px;">
                                    <div class="px-4 py-3 border-bottom">
                                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                    <div class="dropdown-divider my-2"></div>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard.index') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-primary"></i> Tableau de bord
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                                        <i class="fas fa-user-circle me-2 text-primary"></i> Mon Profil
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('preferences.show') }}">
                                        <i class="fas fa-cog me-2 text-primary"></i> Paramètres
                                    </a>
                                    <div class="dropdown-divider my-2"></div>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('transfers.book') }}">
                                        <i class="fas fa-car-side me-2 text-primary"></i> Réserver un Transfert
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('transfers.my') }}">
                                        <i class="fas fa-history me-2 text-primary"></i> Mes Transferts
                                    </a>
                                    <div class="dropdown-divider my-2"></div>
                                    <a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </a>
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
