@include('_header')
<section class="products">
    <div class="container">
        <h1 class="page-title mb-4">Nos voitures</h1>
        <div class="row g-4">
            <!-- Filtre de gauche -->
            <div class="col-lg-3">
                <div class="filtre-container">
                    <div class="filtre">
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filtres</h5>
                            <div class="filter-section">
                                <h6 class="mb-2">Type de véhicule :</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="compactCheckbox" value="compact">
                                    <label class="form-check-label" for="compactCheckbox">
                                        Compact
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="sedanCheckbox" value="sedan">
                                    <label class="form-check-label" for="sedanCheckbox">
                                        Sedan
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="berlineCheckbox" value="berline">
                                    <label class="form-check-label" for="berlineCheckbox">
                                        Berline
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="pickupCheckbox" value="pickup">
                                    <label class="form-check-label" for="pickupCheckbox">
                                        Pick-up
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="suvCheckbox" value="suv">
                                    <label class="form-check-label" for="suvCheckbox">
                                        SUV
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="filter-section">
                            <h6 class="mb-2">Capacité :</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="persons2Checkbox" value="2">
                                <label class="form-check-label" for="persons2Checkbox">
                                    2 personnes
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="persons4Checkbox" value="4">
                                <label class="form-check-label" for="persons4Checkbox">
                                    4 personnes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="persons5Checkbox" value="5">
                                <label class="form-check-label" for="persons5Checkbox">
                                    5 personnes
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col-lg-9">
                <div class="search-container mb-3">
                    <div class="input-group">
                        <input type="text" id="search" class="form-control" placeholder="Rechercher une voiture...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search me-1"></i> Rechercher
                        </button>
                    </div>
                </div>

                <div class="all-products">
                    @forelse ($cars as $car)
                        <div class="item">
                            <div class="car-image">
                                <img src="{{ asset($car->images) }}" alt="{{ $car->brand }} {{ $car->model }}" class="img-fluid">
                            </div>
                            <div class="item-content">
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
                                <a href="{{ route('cars.detail', ['id' => $car->id]) }}" class="btn-voir-plus">
                                    Voir les détails <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="no-results text-center py-5">
                            <i class="fas fa-car-crash fa-3x mb-3"></i>
                            <h4>Aucun véhicule trouvé</h4>
                            <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@include('_footer')