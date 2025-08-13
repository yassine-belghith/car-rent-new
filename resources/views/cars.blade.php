@extends('layouts.app')

@push('styles')
<style>
    body, html {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f5f5f7;
        color: #1c1c1e;
    }

    /* Page Layout */
    .products {
        padding: 2rem 0;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #1c1c1e;
    }

    /* Filters */
    .filtre-container {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        padding: 1.5rem;
        border-radius: 1.2rem;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    .filtre h5 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1c1c1e;
        margin-bottom: 1.5rem;
    }
    .filter-section h6 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #3a3a3c;
        margin-bottom: 1rem;
    }
    .form-check-label {
        font-size: 0.9rem;
        color: #3a3a3c;
    }

    /* Search Box */
    .search-container .form-control {
        border-radius: 999px 0 0 999px;
        border: 1px solid #d1d1d6;
        padding: 0.6rem 1rem;
    }
    .search-container .btn {
        border-radius: 0 999px 999px 0;
        background: #007aff;
        border: none;
    }
    .search-container .btn i {
        color: white;
    }

    /* Car Cards */
    .all-products .item {
        display: flex;
        flex-wrap: wrap;
        background-color: white;
        border-radius: 1.2rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .all-products .item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .car-image {
        flex: 0 0 180px;
        margin-right: 1.5rem;
    }
    .car-image img {
        width: 100%;
        height: auto;
        border-radius: 1rem;
        object-fit: cover;
    }

    .item-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .car-brand {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1c1c1e;
    }

    .car-details {
        font-size: 0.9rem;
        color: #3a3a3c;
    }
    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .detail-item i {
        width: 20px;
        text-align: center;
        margin-right: 0.5rem;
        color: #8e8e93;
    }

    /* Voir plus button */
    .btn-voir-plus {
        display: inline-block;
        margin-top: 1rem;
        font-weight: 600;
        color: #007aff;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    .btn-voir-plus:hover {
        opacity: 0.7;
    }

    /* Pagination */
    .pagination-container nav {
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<section class="products">
    <div class="container">
        @if(isset($search) && !empty($search))
            <h1 class="page-title">Résultats pour : <span style="color:#007aff">"{{ $search }}"</span></h1>
        @else
            <h1 class="page-title">Nos voitures</h1>
        @endif

        <form action="{{ route('car.search') }}" method="GET">
            <div class="row g-4">
                <!-- Filters -->
                <div class="col-lg-3">
                    <div class="filtre-container">
                        <div class="filtre">
                            <div class="mb-4">
                                <h5><i class="fas fa-filter me-2" style="color:#007aff"></i>Filtres</h5>

                                <!-- Vehicle Type -->
                                <div class="filter-section">
                                    <h6>Type de véhicule :</h6>
                                    @foreach(['compact','sedan','berline','pickup','suv'] as $type)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="type[]" id="{{ $type }}Checkbox" value="{{ $type }}" {{ in_array($type, request('type', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $type }}Checkbox">{{ ucfirst($type) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="filter-section mb-4">
                                <h6>Date de disponibilité :</h6>
                                <div class="mb-2">
                                    <label for="start_date" class="form-label small">Début</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div>
                                    <label for="end_date" class="form-label small">Fin</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                            </div>

                            <!-- Capacity -->
                            <div class="filter-section mb-4">
                                <h6>Capacité :</h6>
                                @foreach(['2'=>'2 personnes','4'=>'4 personnes','5'=>'5 personnes'] as $cap => $label)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="capacity[]" id="persons{{ $cap }}Checkbox" value="{{ $cap }}" {{ in_array($cap, request('capacity', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="persons{{ $cap }}Checkbox">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary w-100" style="background:#007aff;border:none;border-radius:999px;">Appliquer les filtres</button>
                        </div>
                    </div>
                </div>

                <!-- Cars List -->
                <div class="col-lg-9">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Search bar -->
                    <div class="search-container mb-3">
                        <div class="input-group">
                            <input type="text" id="search" name="location" class="form-control" placeholder="Rechercher une voiture..." value="{{ $search ?? '' }}">
                            <button class="btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Cars -->
                    <div class="all-products">
                        @forelse ($cars as $car)
                            <div class="item">
                                <div class="car-image">
                                    <img src="{{ asset($car->images) }}" alt="{{ $car->brand }} {{ $car->model }}">
                                </div>
                                <div class="item-content">
                                    <div>
                                        <h5 class="car-brand">{{ $car->brand }} {{ $car->model }}</h5>
                                        <div class="car-details">
                                            <div class="detail-item">
                                                <i class="fas fa-car me-2"></i>
                                                <span>Type: {{ $car->type ?? 'Standard' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <i class="fas fa-users me-2"></i>
                                                <span>Sièges: {{ $car->seats ?? 4 }} personnes</span>
                                            </div>
                                            <div class="detail-item price">
                                                <i class="fas fa-tag me-2"></i>
                                                <span>À partir de <strong>19$</strong> /jour</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('cars.detail', ['car' => $car->id]) }}" class="btn-voir-plus">
                                        Voir les détails <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="no-results text-center py-5">
                                <i class="fas fa-car-crash fa-3x mb-3"></i>
                                @if(isset($search) && !empty($search))
                                    <h4>Aucun véhicule trouvé pour "{{ $search }}"</h4>
                                    <p class="text-muted">Essayez d'autres mots-clés ou modifiez les filtres.</p>
                                @else
                                    <h4>Aucun véhicule disponible pour le moment</h4>
                                    <p class="text-muted">Veuillez revenir plus tard.</p>
                                @endif
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container mt-4">
                        {{ $cars->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
