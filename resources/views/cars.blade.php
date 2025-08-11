@include('_header')
<section class="products">
    <div class="container">
        @if(isset($search) && !empty($search))
                <h1 class="page-title mb-4">Résultats pour : <span class="text-primary">"{{ $search }}"</span></h1>
            @else
                <h1 class="page-title mb-4">Nos voitures</h1>
            @endif
        <form action="{{ route('car.search') }}" method="GET">
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
                                        <input class="form-check-input" type="checkbox" name="type[]" id="compactCheckbox" value="compact" {{ in_array('compact', request('type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="compactCheckbox">Compact</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="type[]" id="sedanCheckbox" value="sedan" {{ in_array('sedan', request('type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sedanCheckbox">Sedan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="type[]" id="berlineCheckbox" value="berline" {{ in_array('berline', request('type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="berlineCheckbox">Berline</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="type[]" id="pickupCheckbox" value="pickup" {{ in_array('pickup', request('type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pickupCheckbox">Pick-up</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="type[]" id="suvCheckbox" value="suv" {{ in_array('suv', request('type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="suvCheckbox">SUV</label>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-section mb-4">
                                <h6 class="mb-2">Date de disponibilité :</h6>
                                <div class="mb-2">
                                    <label for="start_date" class="form-label small">Début</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div>
                                    <label for="end_date" class="form-label small">Fin</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                            </div>

                            <div class="filter-section mb-4">
                                <h6 class="mb-2">Capacité :</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="capacity[]" id="persons2Checkbox" value="2" {{ in_array('2', request('capacity', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="persons2Checkbox">2 personnes</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="capacity[]" id="persons4Checkbox" value="4" {{ in_array('4', request('capacity', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="persons4Checkbox">4 personnes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="capacity[]" id="persons5Checkbox" value="5" {{ in_array('5', request('capacity', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="persons5Checkbox">5 personnes</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Appliquer les filtres</button>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
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
                    <div class="search-container mb-3">
                        <div class="input-group">
                            <input type="text" id="search" name="location" class="form-control" placeholder="Rechercher une voiture..." value="{{ $search ?? '' }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search me-1"></i>
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
                            @if(isset($search) && !empty($search))
                                <h4>Aucun véhicule trouvé pour "{{ $search }}"</h4>
                                <p class="text-muted">Essayez d'utiliser d'autres mots-clés ou de vérifier nos filtres.</p>
                            @else
                                <h4>Aucun véhicule disponible pour le moment</h4>
                                <p class="text-muted">Veuillez revenir plus tard.</p>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@include('_footer')