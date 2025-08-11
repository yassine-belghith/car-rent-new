@include('_header')
<section class="detail py-5 bg-white">
    <div class="container d-flex h-100">
        <div class="informations w-50 h-100 px-5">
            <img src="{{ asset($car->images)}}" alt="voiture" class="w-100 h-50"/>
            <div class="mt-3">
                <h2 class="mb-2 fs-5 fw-medium text-center text-bg-dark p-3 mb-3">{{ $car->model }}</h2>
                <p class="mb-2 fs-5 fw-light"><b>Designation</b>: {{ $car->brand }}</p>
                <p class="mb-2 fs-5 fw-light"><b>Model</b>: {{ $car->model }}</p>
                <p class="mb-2 fs-5 fw-light"><b>Actuellement Disponible</b>: 
                    @if ( $car->availability == 1 )
                        Oui
                    @else
                        Non
                    @endif
                </p>
                <p class="mb-2 fs-5 fw-light"><b>Année d'apparution</b>: {{ $car->year }}</p>
                <p class="mb-2 fs-5 fw-light"><b>Description</b>: {{ $car->description }}</p>
            </div>
        </div>
        <div class="planification w-50 h-100 d-flex flex-column justify-content-between">
            <h3 class="text-center text-bg-dark p-2 fw-light">Planifier une réversation</h3>
            <div class="my-3 reservations">
                <p class="text-center fs-5 fw-medium">Les réservation en cours sur cette voiture</p>
                @forelse ($rentals as $rental)
                    <ul>
                        <li class="fs-4">{{ Str::substr($rental->rental_date, 0, 10) }} - {{ Str::substr($rental->return_date, 0, 10) }}</li>
                    </ul>
                @empty
                    <p class="text-center mt-5">Aucune réservation planifiée sur cette voiture</p>
                @endforelse
            </div>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="admin-reservation-link text-center">
                    <p class="fs-5">Vous êtes connecté en tant qu'administrateur.</p>
                    <a href="{{ route('dashboard.rentals.create') }}" class="btn btn-primary btn-lg mt-2">
                        <i class="fas fa-plus-circle me-2"></i> Créer une location (Admin)
                    </a>
                </div>
            @else
                <form class="new-reservation" method="POST" action="{{ route('rental.user.store', ['carId' => $car->id ]) }}">
                    @csrf
                    <div class="mt-4">
                        <label for="pickupDate">Date de prise en charge :</label>
                        <input type="date" id="pickupDate" class="form-control" name="rental_date" />
                    </div>
                    <div class="mt-3">
                        <label for="returnDate">Date de retour :</label>
                        <input type="date" id="returnDate" class="form-control" name="return_date" />
                    </div>
                    <div class="mt-3">
                        <label for="driver_id">Chauffeur :</label>
                        <select id="driver_id" class="form-control" name="driver_id">
                            <option value="">Aucun</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(session('error'))
                        <div class="mt-3 alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->reservationErrors->any())
                        <div class="mt-3 alert alert-danger">
                            <ul>
                                @foreach ($errors->reservationErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-dark mt-3">Réserver cette voiture</button>
                </form>
            @endif
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">Confirmation de réservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Votre réservation pour la {{ $car->model }} a été
                    confirmée.</p>
                <p>Le montant total de la location est de 50 €/jour.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pickupDateInput = document.getElementById('pickupDate');
    const returnDateInput = document.getElementById('returnDate');
    const driverSelect = document.getElementById('driver_id');

    function fetchAvailableDrivers() {
        const startDate = pickupDateInput.value;
        const endDate = returnDateInput.value;

        if (startDate && endDate && driverSelect) {
            // Disable driver select while loading
            driverSelect.disabled = true;
            driverSelect.innerHTML = '<option>Chargement des chauffeurs...</option>';

            const url = `{{ route('api.available-drivers') }}?start_date=${startDate}&end_date=${endDate}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(drivers => {
                    driverSelect.innerHTML = ''; // Clear existing options
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Aucun';
                    driverSelect.appendChild(defaultOption);

                    if (drivers.length > 0) {
                        drivers.forEach(driver => {
                            const option = document.createElement('option');
                            option.value = driver.id;
                            option.textContent = driver.name;
                            driverSelect.appendChild(option);
                        });
                    } else {
                        const noDriverOption = document.createElement('option');
                        noDriverOption.disabled = true;
                        noDriverOption.textContent = 'Aucun chauffeur disponible';
                        driverSelect.appendChild(noDriverOption);
                    }
                })
                .catch(error => {
                    console.error('Error fetching available drivers:', error);
                    driverSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                })
                .finally(() => {
                    driverSelect.disabled = false; // Re-enable driver select
                });
        }
    }

    if (pickupDateInput && returnDateInput) {
        pickupDateInput.addEventListener('change', fetchAvailableDrivers);
        returnDateInput.addEventListener('change', fetchAvailableDrivers);
    }
});
</script>

@include('_footer')