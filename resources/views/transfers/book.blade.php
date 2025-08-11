@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            cursor: pointer;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Réserver un Transfert</h4>
                </div>
                <div class="card-body">
                    <p class="card-text mb-4">Veuillez remplir les détails ci-dessous pour planifier votre transfert.</p>

                    <form action="{{ route('transfers.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div id="map" style="height: 400px; width: 100%;"></div>
                                <p class="form-text text-muted">Cliquez sur les boutons puis sur la carte pour définir les lieux de prise en charge et de dépose.</p>
                            </div>
                            <div class="col-md-6 mt-3">
                                <button type="button" id="set-pickup" class="btn btn-outline-primary">Définir le lieu de prise en charge</button>
                                <p id="pickup-coords" class="mt-2">Lieu non défini.</p>
                            </div>
                            <div class="col-md-6 mt-3">
                                <button type="button" id="set-dropoff" class="btn btn-outline-secondary">Définir le lieu de dépose</button>
                                <p id="dropoff-coords" class="mt-2">Lieu non défini.</p>
                            </div>
                        </div>

                        <input type="hidden" name="pickup_latitude" id="pickup_latitude">
                        <input type="hidden" name="pickup_longitude" id="pickup_longitude">
                        <input type="hidden" name="dropoff_latitude" id="dropoff_latitude">
                        <input type="hidden" name="dropoff_longitude" id="dropoff_longitude">

                        <div class="form-group mt-4">
                            <label for="car_id"><strong>Choisissez un Véhicule</strong></label>
                            <select name="car_id" id="car_id" class="form-control @error('car_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Sélectionnez un véhicule --</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                        {{ $car->brand }} {{ $car->model }}
                                    </option>
                                @endforeach
                            </select>
                            @error('car_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="pickup_datetime"><strong>Date et Heure de Prise en Charge</strong></label>
                            <input type="datetime-local" name="pickup_datetime" id="pickup_datetime" class="form-control @error('pickup_datetime') is-invalid @enderror" value="{{ old('pickup_datetime') }}" required>
                            @error('pickup_datetime')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr>
                        <h5 class="mt-4 mb-3">Informations Complémentaires</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passenger_count">Nombre de Passagers</label>
                                    <input type="number" name="passenger_count" id="passenger_count" class="form-control @error('passenger_count') is-invalid @enderror" value="{{ old('passenger_count', 1) }}" required min="1">
                                    @error('passenger_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="luggage_count">Nombre de Bagages</label>
                                    <input type="number" name="luggage_count" id="luggage_count" class="form-control @error('luggage_count') is-invalid @enderror" value="{{ old('luggage_count', 0) }}" required min="0">
                                    @error('luggage_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="airline">Compagnie Aérienne (Optionnel)</label>
                                    <input type="text" name="airline" id="airline" class="form-control @error('airline') is-invalid @enderror" value="{{ old('airline') }}">
                                    @error('airline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="flight_number">Numéro de Vol (Optionnel)</label>
                                    <input type="text" name="flight_number" id="flight_number" class="form-control @error('flight_number') is-invalid @enderror" value="{{ old('flight_number') }}">
                                    @error('flight_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="special_instructions">Instructions Spéciales (Optionnel)</label>
                            <textarea name="special_instructions" id="special_instructions" rows="3" class="form-control @error('special_instructions') is-invalid @enderror">{{ old('special_instructions') }}</textarea>
                            @error('special_instructions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Soumettre la Demande</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Initialize the map
        const map = L.map('map').setView([48.8566, 2.3522], 13); // Centered on Paris
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // 2. Get DOM elements
        const pickupLatInput = document.getElementById('pickup_latitude');
        const pickupLngInput = document.getElementById('pickup_longitude');
        const dropoffLatInput = document.getElementById('dropoff_latitude');
        const dropoffLngInput = document.getElementById('dropoff_longitude');
        const pickupCoordsP = document.getElementById('pickup-coords');
        const dropoffCoordsP = document.getElementById('dropoff-coords');

        // 3. State variables
        let currentSelection = null; // 'pickup' or 'dropoff'
        let pickupMarker = null;
        let dropoffMarker = null;

        // 4. Button event listeners
        document.getElementById('set-pickup').addEventListener('click', () => {
            currentSelection = 'pickup';
            document.getElementById('map').style.cursor = 'crosshair';
        });

        document.getElementById('set-dropoff').addEventListener('click', () => {
            currentSelection = 'dropoff';
            document.getElementById('map').style.cursor = 'crosshair';
        });

        // 5. Map click event listener
        map.on('click', function(e) {
            if (!currentSelection) return;

            const { lat, lng } = e.latlng;

            if (currentSelection === 'pickup') {
                // Update or create pickup marker
                if (pickupMarker) {
                    pickupMarker.setLatLng(e.latlng);
                } else {
                    pickupMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
                }
                pickupMarker.bindPopup('<b>Lieu de Prise en Charge</b>').openPopup();

                // Update form and display
                pickupLatInput.value = lat;
                pickupLngInput.value = lng;
                pickupCoordsP.textContent = `Prise en charge: ${lat.toFixed(5)}, ${lng.toFixed(5)}`;

                pickupMarker.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    pickupLatInput.value = position.lat;
                    pickupLngInput.value = position.lng;
                    pickupCoordsP.textContent = `Prise en charge: ${position.lat.toFixed(5)}, ${position.lng.toFixed(5)}`;
                });

            } else if (currentSelection === 'dropoff') {
                // Update or create dropoff marker
                if (dropoffMarker) {
                    dropoffMarker.setLatLng(e.latlng);
                } else {
                    dropoffMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
                }
                dropoffMarker.bindPopup('<b>Lieu de Dépose</b>').openPopup();

                // Update form and display
                dropoffLatInput.value = lat;
                dropoffLngInput.value = lng;
                dropoffCoordsP.textContent = `Dépose: ${lat.toFixed(5)}, ${lng.toFixed(5)}`;

                dropoffMarker.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    dropoffLatInput.value = position.lat;
                    dropoffLngInput.value = position.lng;
                    dropoffCoordsP.textContent = `Dépose: ${position.lat.toFixed(5)}, ${position.lng.toFixed(5)}`;
                });
            }

            // Reset selection mode
            currentSelection = null;
            document.getElementById('map').style.cursor = '';
        });
    });
</script>
@endpush
