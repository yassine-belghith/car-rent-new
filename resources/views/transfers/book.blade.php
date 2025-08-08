@extends('layouts.app')

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pickup_location_id"><strong>Lieu de Prise en Charge</strong></label>
                                    <select name="pickup_location_id" id="pickup_location_id" class="form-control @error('pickup_location_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Choisissez un lieu --</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}" {{ old('pickup_location_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pickup_location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dropoff_location_id"><strong>Lieu de Dépose</strong></label>
                                    <select name="dropoff_location_id" id="dropoff_location_id" class="form-control @error('dropoff_location_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Choisissez un lieu --</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}" {{ old('dropoff_location_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('dropoff_location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
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
