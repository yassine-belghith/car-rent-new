@extends('layouts.app')

@section('content')
<style>
    body, html {
        overflow-x: hidden; /* Prevent horizontal scroll */
    }

    .hero-section {
        position: relative; /* Establishes a stacking context */
        padding: 8rem 0;
        background: url('https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
        background-size: cover;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        animation: fadeIn 2s ease-in-out;
    }

    .hero-content .display-3 {
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        animation: slideInDown 1s ease-in-out;
    }

    .hero-content .lead {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        animation: slideInUp 1s ease-in-out;
    }

        .booking-panel {
        position: relative; /* Required for z-index to work */
        z-index: 2; /* Lifts the panel above the hero overlay */
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 15px;
        margin-top: 2rem;
        max-width: 900px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .form-label {
        font-weight: 500;
        color: #eee;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 8px;
    }

    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.2);
        border-color: var(--bs-primary);
        color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.5);
    }

    .booking-panel .form-control::placeholder {
        color: #ccc;
    }

    .booking-panel .btn-primary {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }

    /* Booking Toggle Switch */
    .booking-toggle-switch-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    .booking-toggle-switch-container .btn-group {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50px;
        padding: 5px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .booking-toggle-switch-container .btn-toggle {
        border: none;
        background-color: transparent;
        color: #fff;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
        z-index: 1;
    }
    .booking-toggle-switch-container .btn-check:checked + .btn-toggle {
        background-color: var(--bs-primary);
        color: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .features-section {
        padding: 6rem 0;
        background-color: #f8f9fa;
    }

    .feature-card {
        background: #fff;
        border: none;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        font-size: 3rem;
        color: var(--bs-primary);
        margin-bottom: 1.5rem;
    }

    .popular-vehicles-section {
        padding: 6rem 0;
    }

    .vehicle-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .vehicle-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .vehicle-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .vehicle-card .card-body {
        padding: 1.5rem;
    }

    .vehicle-card .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.8em;
    }

    .cta-section {
        padding: 6rem 0;
        background: linear-gradient(45deg, var(--bs-primary), var(--bs-secondary));
        color: #fff;
        text-align: center;
    }

    .cta-button {
        background-color: transparent;
        border: 2px solid #fff;
        color: #fff;
        padding: 1rem 2.5rem;
        font-weight: 700;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .cta-button:hover {
        background-color: #fff;
        color: var(--bs-primary);
        transform: translateY(-3px);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Typeahead Autocomplete Styles */
    .twitter-typeahead {
        width: 100%;
    }
    .tt-menu {
        width: 100%;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,0.2);
        border-radius: 8px;
        box-shadow: 0 5px 10px rgba(0,0,0,.2);
        padding: 8px 0;
    }
    .tt-suggestion {
        padding: 8px 20px;
        font-size: 1rem;
        line-height: 1.5;
        color: #333;
    }
    .tt-suggestion:hover {
        cursor: pointer;
        background-color: #f0f0f0;
    }
    .tt-suggestion.tt-cursor {
        color: #fff;
        background-color: var(--bs-primary);
    }
</style>

<header class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="hero-content">
                    <h1 class="display-3 mb-4">Location & Transfert Privé</h1>
                    <p class="lead mb-5">Le véhicule parfait pour chaque étape de votre voyage. Découvrez notre flotte premium et réservez votre trajet en toute simplicité.</p>
                </div>
                
                <div class="booking-panel mx-auto" style="position: relative; z-index: 9999;">
                    <!-- Toggle Switch -->
                    <div class="booking-toggle-switch-container">
                        <div class="btn-group" role="group" aria-label="Booking Type Toggle">
                            <input type="radio" class="btn-check" name="booking-type" id="rental-toggle" autocomplete="off" checked data-bs-toggle="tab" data-bs-target="#rental-panel">
                            <label class="btn btn-toggle" for="rental-toggle"><i class="fas fa-car me-2"></i>Location</label>

                            <input type="radio" class="btn-check" name="booking-type" id="transfer-toggle" autocomplete="off" data-bs-toggle="tab" data-bs-target="#transfer-panel">
                            <label class="btn btn-toggle" for="transfer-toggle"><i class="fas fa-taxi me-2"></i>Transfert</label>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-toggle">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="pickup_location" class="form-label">Lieu de Récupération</label>
                                        <input type="text" class="form-control" id="pickup_location" name="pickup_location" placeholder="Ville, aéroport" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Date de Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Date de Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-toggle">
                        <form action="{{ route('transfers.book') }}" method="GET" class="p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="transfer_pickup" class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Lieu de Prise en Charge</label>
                                    <input type="text" class="form-control form-control-lg" id="transfer_pickup" name="pickup_location" placeholder="Adresse de départ" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="transfer_dropoff" class="form-label"><i class="fas fa-map-pin me-2"></i>Lieu de Dépose</label>
                                    <input type="text" class="form-control form-control-lg" id="transfer_dropoff" name="dropoff_location" placeholder="Adresse d'arrivée" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="transfer_datetime" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Date et Heure</label>
                                    <input type="datetime-local" class="form-control form-control-lg" id="transfer_datetime" name="pickup_datetime" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="passenger_count" class="form-label"><i class="fas fa-users me-2"></i>Nombre de Passagers</label>
                                    <input type="number" class="form-control form-control-lg" id="passenger_count" name="passenger_count" value="1" min="1" required>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Voir les Options de Transfert</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    <!-- Features Section -->
    <div class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pourquoi Nous Choisir ?</h2>
                <p class="lead text-muted">Nous offrons des services de location et de transfert de qualité supérieure pour rendre votre voyage inoubliable.</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-car-side"></i></div>
                        <h4 class="fw-bold">Véhicules Premium</h4>
                        <p class="text-muted">Flotte moderne et bien entretenue avec une variété de modèles pour répondre à tous vos besoins.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
                        <h4 class="fw-bold">Chauffeurs Professionnels</h4>
                        <p class="text-muted">Nos chauffeurs expérimentés et courtois assurent votre confort et votre sécurité tout au long du trajet.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-headset"></i></div>
                        <h4 class="fw-bold">Service Client 24/7</h4>
                        <p class="text-muted">Disponibilité permanente pour répondre à vos besoins de transport à tout moment, où que vous soyez.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Vehicles Section -->
    <div class="popular-vehicles-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Nos Véhicules Populaires</h2>
                <p class="lead text-muted">Découvrez nos modèles les plus demandés, parfaits pour tous vos déplacements.</p>
            </div>
            <div class="row">
                @if($cars->count())
                    @foreach($cars as $car)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card vehicle-card h-100">
                                <img src="{{ $car->image_url ?? 'https://via.placeholder.com/400x300' }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">{{ $car->brand }} {{ $car->model }}</h5>
                                    <p class="card-text text-muted mb-1">Année: {{ $car->year }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('cars.detail', ['id' => $car->id]) }}" class="btn btn-sm btn-primary">Voir les détails</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-car fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun véhicule disponible pour le moment.</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('car.cars') }}" class="btn btn-lg btn-outline-primary">Voir Tous Nos Véhicules</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-3">Prêt à Commencer Votre Voyage ?</h2>
                    <p class="lead mb-4">Réservez dès maintenant votre véhicule et profitez d'un service de qualité premium.</p>
                    <a href="{{ route('car.cars') }}" class="cta-button btn btn-lg">Explorer Nos Services</a>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection


