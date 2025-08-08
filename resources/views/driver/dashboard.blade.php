@extends('layouts.dashboard')

@section('title', 'Tableau de bord Chauffeur')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Mes Transferts Assignés</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date et Heure de Prise en Charge</th>
                        <th>Client</th>
                        <th>Lieu de Prise en Charge</th>
                        <th>Lieu de Destination</th>
                        <th>Statut</th>
                        <th>Confirmation Chauffeur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transfers as $transfer)
                        <tr>
                            <td>{{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y H:i') : 'Non spécifié' }}</td>
                            <td>{{ $transfer->customer_name }}</td>
                            <td>{{ $transfer->pickup_location }}</td>
                            <td>{{ $transfer->dropoff_location }}</td>
                            <td>
                                <span class="badge @switch($transfer->status)
                                    @case('pending') bg-warning @break
                                    @case('confirmed') bg-success @break
                                    @case('cancelled') bg-danger @break
                                    @case('completed') bg-info @break
                                @endswitch">{{ ucfirst($transfer->status) }}</span>
                            </td>
                            <td>
                                <span class="badge @switch($transfer->driver_confirmation_status)
                                    @case('pending') bg-warning @break
                                    @case('confirmed') bg-success @break
                                    @case('declined') bg-danger @break
                                    @default bg-secondary @break
                                @endswitch">{{ ucfirst($transfer->driver_confirmation_status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('driver.transfers.show', $transfer) }}" class="btn btn-sm btn-info">Voir Détails</a>
                                @if ($transfer->driver_confirmation_status == 'pending')
                                    <form action="{{ route('driver.transfers.confirm', $transfer) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Confirmer</button>
                                    </form>
                                    <form action="{{ route('driver.transfers.decline', $transfer) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Refuser</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Vous n'avez aucun transfert assigné pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $transfers->links() }}
        </div>
    </div>
</div>
@endsection
