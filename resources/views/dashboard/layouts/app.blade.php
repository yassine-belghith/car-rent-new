<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tableau de bord - Location de Voitures')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}" />
    
    <style>

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f1f5f9;
            color: var(--gray-800);
            line-height: 1.6;
            scroll-behavior: smooth;
        }

        /* Sidebar */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, var(--darker) 0%, var(--gray-900) 100%);
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease-in-out;
            position: fixed;
            z-index: 1040;
            transform: translateX(0);
            overflow-y: auto;
            left: 0;
            top: 0;
            -webkit-overflow-scrolling: touch;
        }
        
        #wrapper.toggled #sidebar-wrapper {
            transform: translateX(-100%);
        }
        
        /* Mobile sidebar overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1039;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        .navbar .navbar-toggler {
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            font-size: 1.25rem;
            line-height: 1;
            background: var(--white);
            color: var(--gray-700);
            border-radius: var(--radius-sm);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .sidebar-heading {
            padding: 1.75rem 1.5rem 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-heading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .sidebar-heading h4 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .sidebar-heading small {
            opacity: 0.8;
            font-size: 0.8rem;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            border-radius: 0.5rem;
            margin: 0.25rem 1rem;
            width: calc(100% - 2rem);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            background: transparent;
        }
        
        .list-group-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transform: scaleY(0);
            transform-origin: center;
            transition: transform 0.3s ease;
        }

        .list-group-item i {
            width: 24px;
            text-align: center;
            margin-right: 0.75rem;
            color: var(--gray-500);
            transition: var(--transition);
        }

        .list-group-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transform: translateX(8px);
        }
        
        .list-group-item:hover::before {
            transform: scaleY(1);
        }

        .list-group-item:hover i {
            color: var(--primary);
        }

        .list-group-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
            font-weight: 600;
        }
        
        .list-group-item.active::before {
            transform: scaleY(1);
        }

        .list-group-item.active i {
            color: white;
        }

        /* Main Content */
        #page-content-wrapper {
            width: calc(100% - 280px);
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease-in-out;
            position: relative;
            background-color: var(--gray-50);
        }

        /* Mobile styles */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
            }
            #sidebar-wrapper.show {
                transform: translateX(0);
            }
            #page-content-wrapper {
                width: 100%;
                margin-left: 0;
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
            }
            
            #wrapper.toggled #sidebar-wrapper {
                transform: translateX(0);
            }
            
            #page-content-wrapper {
                margin-left: 0;
            }
            
            #wrapper.toggled #page-content-wrapper {
                margin-left: 0;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }
        
        @media (max-width: 991.98px) {
            #page-content-wrapper {
                margin-left: 0;
            }
        }

        /* Navbar */
        .navbar {
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            margin: 1rem 1.5rem 1.5rem;
            border: 1px solid var(--border-color);
        }

        .navbar .nav-link {
            color: var(--gray-700);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: var(--primary);
            background: var(--primary-lighter);
        }
        
        .navbar .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
            transform: translateX(-50%);
        }
        
        .navbar .nav-link:hover:after,
        .navbar .nav-link.active:after {
            width: calc(100% - 2rem);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--dark);
            border-radius: 0.75rem 0.75rem 0 0 !important;
        }

        /* Buttons - Using theme.css styles */
        .btn {
            /* All button styles are now in theme.css */
        }

        /* Primary button styles are now in theme.css */

        /* Outline button styles are now in theme.css */

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--gray-100);
            border-bottom: 2px solid var(--gray-200);
            color: var(--gray-700);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .table > :not(:first-child) {
            border-top: none;
        }

        /* Badges */
        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
            border-radius: 50rem;
            font-size: 0.75em;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                margin-left: -260px;
            }

            #sidebar-wrapper.toggled {
                margin-left: 0;
            }

            #page-content-wrapper {
                margin-left: 0;
            }

            #wrapper.toggled #page-content-wrapper {
                margin-left: 0;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-200);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button class="btn btn-dark d-lg-none position-fixed" id="sidebarToggle" style="z-index: 1050; top: 10px; left: 10px;">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Sidebar -->
        <div class="bg-dark border-right vh-100 position-fixed" id="sidebar-wrapper">
            <div class="d-flex justify-content-between align-items-center px-3 py-3 d-lg-none">
                <div class="sidebar-heading-text text-white">
                    <h4 class="mb-0">Menu</h4>
                </div>
                <button class="btn btn-link text-white p-0" id="closeSidebar">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <div class="sidebar-heading d-none d-lg-block">
                <div class="mb-2">
                    <img src="{{ asset('assets/rentlogo.png') }}" alt="Logo" style="max-width: 140px; height: auto;">
                </div>
                <h4 class="mb-0">Location de Voitures</h4>
                <small>Tableau de bord</small>
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="{{ route('dashboard.index') }}" class="list-group-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                </a>
                <a href="{{ route('dashboard.users') }}" class="list-group-item {{ request()->routeIs('dashboard.users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Utilisateurs
                    <span class="badge bg-primary float-end">{{ App\Models\User::count() }}</span>
                </a>
                <a href="{{ route('dashboard.cars') }}" class="list-group-item {{ request()->routeIs('dashboard.cars*') ? 'active' : '' }}">
                    <i class="fas fa-car"></i> Véhicules
                    <span class="badge bg-success float-end">{{ App\Models\Car::count() }}</span>
                </a>
                <a href="{{ route('dashboard.rentals.index') }}" class="list-group-item {{ request()->routeIs('dashboard.rentals*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Locations
                    <span class="badge bg-info float-end">{{ App\Models\Rental::count() }}</span>
                </a>
                <a href="{{ route('dashboard.contact-messages.index') }}" class="list-group-item {{ request()->routeIs('dashboard.contact-messages*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Messages
                    @php
                        $unreadCount = \App\Models\ContactMessage::unread()->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge bg-danger float-end">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="position-absolute bottom-0 w-100 mb-3">
                    <a href="{{ route('car.acceuil') }}" class="list-group-item">
                        <i class="fas fa-home"></i> Retour au site
                    </a>
                    <form method="POST" action="{{ route('user.logout') }}" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="list-group-item text-danger border-0 bg-transparent w-100 text-start">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper" style="margin-left: 250px; width: calc(100% - 250px); transition: margin 0.3s ease-in-out, width 0.3s ease-in-out;">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-3">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link text-dark p-0 me-3" id="menu-toggle">
                            <i class="fas fa-bars fa-lg"></i>
                        </button>
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-0 fw-bold text-dark">@yield('title', 'Tableau de bord')</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none">Tableau de bord</a></li>
                                    @php
                                        $breadcrumbs = $breadcrumbs ?? [];
                                    @endphp
                                    @foreach($breadcrumbs as $title => $url)
                                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                            @if(!$loop->last && $url)
                                                <a href="{{ $url }}" class="text-decoration-none">{{ $title }}</a>
                                            @else
                                                {{ $title }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="me-2 d-none d-md-block text-end">
                                    <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </small>
                                </div>
                                @if(Auth::user()->avatar_url)
                                    <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="rounded-circle" width="40" height="40">
                                @else
                                    <div class="user-avatar d-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2" aria-labelledby="userDropdown" style="min-width: 220px;">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center py-2 px-3" href="#">
                                        <i class="fas fa-user me-3 text-muted"></i>
                                        <div>
                                            <a href="{{ route('profile.show') }}" class="fw-500 text-decoration-none text-dark">Mon Profil</a>
                                            <small class="text-muted">Paramètres du compte</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center py-2 px-3" href="{{ route('preferences.show') }}">
    <i class="fas fa-cog me-3 text-muted"></i>
    <div>
        <div class="fw-500">Paramètres</div>
        <small class="text-muted">Préférences du système</small>
    </div>
</a>
                                </li>
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <form method="POST" action="{{ route('user.logout') }}" class="w-100">
    @csrf
    <button type="submit" class="dropdown-item d-flex align-items-center py-2 px-3 text-danger">
        <i class="fas fa-sign-out-alt me-3"></i>
        <div class="fw-500">Déconnexion</div>
    </button>
</form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <div class="container-fluid px-3 px-md-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- jQuery 3.6.0 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const wrapper = document.getElementById('wrapper');
            
            // Toggle sidebar
            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('toggled');
                    document.body.classList.toggle('sidebar-open');
                    sidebarOverlay.classList.toggle('active');
                });
            }
            
            // Close sidebar when clicking the close button
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function() {
                    wrapper.classList.add('toggled');
                    document.body.classList.remove('sidebar-open');
                    sidebarOverlay.classList.remove('active');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    wrapper.classList.add('toggled');
                    document.body.classList.remove('sidebar-open');
                    this.classList.remove('active');
                });
            }
            
            // Close sidebar when clicking on a nav link on mobile
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        wrapper.classList.add('toggled');
                        document.body.classList.remove('sidebar-open');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            });
            
            // Handle window resize
            function handleResize() {
                if (window.innerWidth >= 992) {
                    wrapper.classList.remove('toggled');
                    document.body.classList.remove('sidebar-open');
                    sidebarOverlay.classList.remove('active');
                }
            }
            
            window.addEventListener('resize', handleResize);
        });

        // Close sidebar when clicking on nav links (mobile)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991.98) {
                    document.body.classList.remove('sidebar-open');
                    document.getElementById('sidebar-wrapper').classList.remove('show');
                    document.getElementById('sidebarOverlay').classList.remove('active');
                }
            });
        });
    </script>
    
    <!-- Bootstrap 5.3.0 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('scripts')
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Initialize tooltips and popovers
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
            
            // Handle active states for sidebar items
            const currentLocation = location.href;
            const menuItems = document.querySelectorAll('.nav-link');
            
            menuItems.forEach(item => {
                if (item.href === currentLocation) {
                    item.classList.add('active');
                    const parent = item.parentElement;
                    
                    // If it's a dropdown item, also mark the parent as active
                    if (parent.classList.contains('dropdown-item')) {
                        const dropdown = parent.closest('.dropdown');
                        if (dropdown) {
                            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                            if (dropdownToggle) {
                                dropdownToggle.classList.add('active');
                            }
                        }
                    }
                }
            });
        });
    </script>
    
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (!toggleBtn) return;
            
            // Toggle sidebar on button click
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show');
                
                // Toggle overlay
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('active');
                }
                
                // Toggle body class for mobile
                document.body.classList.toggle('sidebar-open');
                
                // Toggle icon between bars and times
                const icon = toggleBtn.querySelector('i');
                if (sidebar.classList.contains('show')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 991.98 && 
                    !sidebar.contains(e.target) && 
                    e.target !== toggleBtn && 
                    !toggleBtn.contains(e.target) &&
                    !e.target.classList.contains('dropdown-toggle')) {
                    
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                    
                    const icon = toggleBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 991.98) {
                    // Desktop view
                    sidebar.classList.add('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                    
                    const icon = toggleBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    // Mobile view
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                }
            }
            
            // Initial check
            handleResize();
            window.addEventListener('resize', handleResize);
        });
        // Handle active states for sidebar items
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.href;
            const menuItems = document.querySelectorAll('.nav-link');
            
            menuItems.forEach(item => {
                if (item.href === currentLocation) {
                    item.classList.add('active');
                    const parent = item.parentElement;
                    
                    // If it's a dropdown item, also mark the parent as active
                    if (parent.classList.contains('dropdown-item')) {
                        const dropdown = parent.closest('.dropdown');
                        if (dropdown) {
                            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                            if (dropdownToggle) {
                                dropdownToggle.classList.add('active');
                            }
                        }
                    }
                }
            });
        });
        });
    </script>
</body>
</html>
