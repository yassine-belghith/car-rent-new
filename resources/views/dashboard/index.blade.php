@extends('dashboard.layouts.app')

@section('title', 'Tableau de bord')

@php
$breadcrumbs = [
    '' => route('dashboard.index')
];
@endphp

@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <div class="d-none d-sm-inline-block">
            <span class="text-muted">Dernière mise à jour: {{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.users') }}" class="btn btn-sm btn-primary mt-3">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Cars Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Véhicules</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCars }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.cars') }}" class="btn btn-sm btn-success mt-3">Voir la flotte</a>
                </div>
            </div>
        </div>

        <!-- Rentals Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Locations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRentals }}</div>
                            <div class="mt-1">
                                <span class="text-warning small">{{ $pendingRentals }} en attente</span><br>
                                <span class="text-success small">{{ $confirmedRentals }} confirmées</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.rentals.index') }}" class="btn btn-sm btn-info mt-3">Voir les locations</a>
                </div>
            </div>
        </div>

        <!-- Transfers Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Transferts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransfers }}</div>
                            <div class="mt-1">
                                <span class="text-warning small">{{ $pendingTransfers }} en attente</span><br>
                                <span class="text-success small">{{ $confirmedTransfers }} confirmés</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.transfers.index') }}" class="btn btn-sm btn-warning mt-3">Voir les transferts</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-bolt text-warning me-2"></i>Actions rapides
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Add User -->
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="card action-card h-100 border-0 text-decoration-none">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                            <i class="fas fa-user-plus fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Nouvel utilisateur</h5>
                                            <p class="text-muted mb-0 small">Ajoutez un nouvel utilisateur au système</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-primary fw-bold py-2">
                                    <span>Commencer <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        <!-- Add Car -->
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="card action-card h-100 border-0 text-decoration-none">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                            <i class="fas fa-car-side fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Nouveau véhicule</h5>
                                            <p class="text-muted mb-0 small">Ajoutez un nouveau véhicule à la flotte</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-success fw-bold py-2">
                                    <span>Commencer <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        <!-- New Rental -->
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="card action-card h-100 border-0 text-decoration-none">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                                            <i class="fas fa-calendar-plus fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Nouvelle location</h5>
                                            <p class="text-muted mb-0 small">Créez une nouvelle réservation</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-info fw-bold py-2">
                                    <span>Commencer <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-history text-primary me-2"></i>Activité récente
                    </h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Activity Item 1 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Nouvelle connexion</h6>
                                        <small class="text-muted">{{ now()->subMinutes(5)->format('H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Vous vous êtes connecté avec succès à votre compte.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-success bg-opacity-10 text-success rounded-circle p-2">
                                        <i class="fas fa-car"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Nouveau véhicule ajouté</h6>
                                        <small class="text-muted">{{ now()->subHours(2)->format('d/m H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Toyota RAV4 2023 a été ajouté à la flotte.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-info bg-opacity-10 text-info rounded-circle p-2">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Nouvelle réservation</h6>
                                        <small class="text-muted">{{ now()->subDays(1)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Réservation #{{ rand(1000, 9999) }} a été créée avec succès.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item 4 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-warning bg-opacity-10 text-warning rounded-circle p-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Alerte de maintenance</h6>
                                        <small class="text-muted">{{ now()->subDays(2)->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Le véhicule #{{ rand(100, 999) }} nécessite une révision.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-center">
                    <a href="#" class="text-primary text-decoration-none fw-bold">
                        Voir plus d'activités <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Card Styles */
    .card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1) !important;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(58, 59, 69, 0.15) !important;
    }
    
    /* Card Header */
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.35rem;
    }
    
    /* Action Cards */
    .action-card {
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(58, 59, 69, 0.1) !important;
    }
    
    .action-card .card-footer {
        background-color: #f8f9fc;
        transition: all 0.3s ease;
    }
    
    .action-card:hover .card-footer {
        background-color: #f1f3f9;
    }
    
    /* Icon Shapes */
    .icon-shape {
        width: 3rem;
        height: 3rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
    }
    
    /* Activity Feed */
    .hover-bg-light {
        transition: all 0.2s ease;
    }
    
    .hover-bg-light:hover {
        background-color: #f8f9fc !important;
    }
    
    /* Status Badges */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    
    /* Buttons */
    .btn {
        border-radius: 0.35rem;
        font-weight: 500;
        padding: 0.375rem 0.75rem;
        font-size: 0.85rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    /* Avatar */
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #fff;
        background-color: #4e73df;
        border-radius: 50%;
    }
    
    /* Text Utilities */
    .text-xs {
        font-size: 0.7rem;
    }
    
    .text-sm {
        font-size: 0.85rem;
    }
    
    /* Custom Shadows */
    .shadow-sm {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1) !important;
    }
    
    /* Custom Backgrounds */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-header .btn {
            margin-top: 0.5rem;
            align-self: flex-end;
        }
    }
    
    /* Animation for cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #d1d3e2;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #b7b9cc;
    }
</style>
@endsection
                