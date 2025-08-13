@extends('layouts.app')

@push('styles')
<style>
    .welcome-page {
        background-color: #f5f5f7;
        color: #1c1c1e;
    }

    /* Hero Section */
    .hero-main {
        position: relative;
        height: 75vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        background: url('https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
        background-size: cover;
    }
    .hero-main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3));
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        padding: 0 1rem;
    }
    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
    }
    .hero-content p {
        font-size: 1.25rem;
        margin: 1.5rem 0 2.5rem;
        color: rgba(255, 255, 255, 0.9);
    }
    .hero-buttons .btn {
        font-size: 1rem;
        font-weight: 600;
        padding: 0.9rem 2rem;
        border-radius: 50px;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
    }
    .hero-buttons .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .hero-buttons .btn-outline-light:hover {
        background-color: #fff;
        color: #007bff;
    }

    /* Sections */
    .section {
        padding: 5rem 0;
    }
    .section-title {
        text-align: center;
        margin-bottom: 3rem;
        font-size: 2.25rem;
        font-weight: 600;
    }

    /* How It Works Section */
    .how-it-works-card {
        text-align: center;
        padding: 2rem;
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    .how-it-works-card .icon {
        font-size: 2.5rem;
        color: #007bff;
        margin-bottom: 1.5rem;
    }
    .how-it-works-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Featured Vehicles Section */
    .vehicle-card {
        background: #ffffff;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    .vehicle-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    .vehicle-card img {
        height: 220px;
        object-fit: cover;
    }
    .vehicle-card .card-body {
        padding: 1.5rem;
    }
    .vehicle-card .card-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .vehicle-card .price {
        font-size: 1.2rem;
        font-weight: 500;
        color: #007bff;
    }

    /* CTA Section */
    .cta-section {
        background: #ffffff;
        padding: 5rem 0;
        text-align: center;
    }
    .cta-section h2 {
        font-size: 2.25rem;
        font-weight: 600;
    }
    .cta-section p {
        max-width: 600px;
        margin: 1rem auto 2rem;
        color: #5a5a5e;
    }
</style>
@endpush

@section('content')
<div class="welcome-page">
    <!-- Hero Section -->
    <section class="hero-main">
        <div class="hero-content">
            <h1>Votre Aventure Commence Ici</h1>
            <p>Découvrez la location de voitures et les transferts privés sans effort. Qualité, confort et fiabilité, tout en un.</p>
            <div class="hero-buttons">
                <a href="{{ route('car.cars') }}" class="btn btn-primary">Parcourir les Voitures</a>
                <a href="{{ route('transfers.book') }}" class="btn btn-outline-light">Réserver un Transfert</a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Réservation Facile en 3 Étapes</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="how-it-works-card">
                        <div class="icon"><i class="fas fa-search"></i></div>
                        <h3>Rechercher</h3>
                        <p>Trouvez la voiture ou le transfert parfait pour vos besoins parmi notre flotte variée.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="how-it-works-card">
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                        <h3>Sélectionner & Réserver</h3>
                        <p>Choisissez vos dates, confirmez vos informations et réservez en toute sécurité en quelques minutes.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="how-it-works-card">
                        <div class="icon"><i class="fas fa-car"></i></div>
                        <h3>Conduire</h3>
                        <p>Récupérez votre voiture ou rencontrez votre chauffeur et profitez d'un voyage agréable et sans tracas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Vehicles Section -->
    <section class="section bg-white">
        <div class="container">
            <h2 class="section-title">Véhicules en Vedette</h2>
            <div class="row g-4">
                @foreach($cars as $car)
                <div class="col-lg-4 col-md-6">
                    <div class="vehicle-card">
                        <img src="{{ $car->image_url ?? 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($car->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">{{ $car->price_per_day }} TND/day</span>
                                <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les Détails</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Prêt à Commencer Votre Aventure ?</h2>
            <p>Créez un compte pour gérer vos réservations, ou explorez notre gamme complète de véhicules pour trouver votre voiture idéale dès aujourd'hui.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">Créer un Compte</a>
                <a href="{{ route('car.cars') }}" class="btn btn-outline-secondary">Explorer Notre Flotte</a>
            </div>
        </div>
    </section>
</div>
@endsection