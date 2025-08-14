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

    /* Modern Search Form */
    .search-form-wrapper {
        background: rgba(255, 255, 255, 0.9);
        padding: 2rem;
        border-radius: 1rem;
        margin-top: 2rem;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        color: #333;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .search-form-wrapper .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 0.3rem;
        display: block;
    }
    .search-form-wrapper .form-control,
    .search-form-wrapper .form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 0.6rem 0.8rem;
        height: auto;
        background-color: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .search-form-wrapper optgroup {
        font-weight: bold;
        color: #333;
    }

    .search-form-wrapper .form-control:focus,
    .search-form-wrapper .form-select:focus {
        border-color: #0033a0;
        box-shadow: 0 0 0 2px rgba(0, 51, 160, 0.15);
        outline: none;
    }
    .search-form-wrapper .btn-primary {
        background-color: #0033a0;
        border-color: #0033a0;
        font-weight: bold;
        padding: 0.6rem 1rem;
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
    }
    .search-form-wrapper .btn-primary:hover {
        background-color: #002269;
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
            <h1>{{ __('messages.welcome_hero_title') }}</h1>
            <p>{{ __('messages.welcome_hero_subtitle') }}</p>
            <div class="booking-form-body">
                <form action="{{ route('car.search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="destination" class="form-label">{{ __('messages.pickup_location_label') }}</label>
                            <select id="destination" name="location" class="form-select">
                                <option value="" disabled selected>{{ __('messages.select_location_placeholder') }}</option>
                                @foreach($destinations as $type => $locations)
                                    <optgroup label="{{ $type }}">
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="start-date" class="form-label">{{ __('messages.start_date_label') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" id="start-date" name="start_date" class="form-control" placeholder="{{ __('dd/mm/yyyy') }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="start_time" class="form-label">{{ __('heure ') }}</label>
                            <select id="start_time" name="start_time" class="form-select">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}:00">{{ sprintf('%02d', $i) }}:00</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="end-date" class="form-label">{{ __('messages.end_date_label') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" id="end-date" name="end_date" class="form-control" placeholder="{{ __('dd/mm/yyyy') }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="end_time" class="form-label">{{ __('heure') }}</label>
                            <select id="end_time" name="end_time" class="form-select">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}:00">{{ sprintf('%02d', $i) }}:00</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.search_button') }}</button>
                        </div>
                    </div>
                </form>
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

    <!-- Featured vehicles section removed -->

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

@push('styles')
<style>
    .booking-form-body {
        background-color: #f8f9fa;
        padding: 3rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .input-group {
        position: relative;
    }

    .input-group .form-control {
        padding-left: 2.5rem;
    }

    .input-group-text {
        position: absolute;
        top: 50%;
        left: 0.75rem;
        transform: translateY(-50%);
        background-color: transparent;
        border: none;
        z-index: 10;
        color: #6c757d;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-2px);
    }

    .form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    optgroup {
        font-weight: bold;
        font-style: italic;
        color: #007bff;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');

        const fpStart = flatpickr(startDateInput, {
            locale: 'fr',
            dateFormat: 'd/m/Y',
            minDate: 'today',
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates[0]) {
                    fpEnd.set('minDate', selectedDates[0]);
                }
            }
        });

        const fpEnd = flatpickr(endDateInput, {
            locale: 'fr',
            dateFormat: 'd/m/Y',
            minDate: startDateInput.value || 'today',
        });
    });
</script>
@endpush