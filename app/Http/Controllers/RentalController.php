<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\RentalVoucherMail;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['user', 'car']);
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('car', function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('license_plate', 'like', "%{$search}%");
                });
            });
        }
        
        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'completed', 'cancelled'])) {
            $query->where('status', $request->status);
        }
        
        // Sort functionality
        $sortBy = $request->input('sort_by', 'rental_date');
        $sortOrder = $request->input('sort_order', 'desc');
        
        // Validate sort fields to prevent SQL injection
        $validSortColumns = ['rental_date', 'return_date', 'total_price', 'created_at'];
        $sortBy = in_array($sortBy, $validSortColumns) ? $sortBy : 'rental_date';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? $sortOrder : 'desc';
        
        $rentals = $query->orderBy($sortBy, $sortOrder)
                        ->paginate(10)
                        ->withQueryString();
        
        return view('dashboard.rentals.index', compact('rentals'));
    }

    public function create(Request $request, $carId = null)
    {
        // If carId is provided, this is a user-facing rental creation
        if ($carId) {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'rental_date' => 'required|date|after_or_equal:today',
                    'return_date' => 'required|date|after:rental_date',
                ]);
            
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator, 'reservationErrors')->withInput();
                }

                $userId = auth()->user()->id;

                if (Carbon::parse($request->input('rental_date'))->lt(Carbon::today())) {
                    return redirect()->back()->with('error', 'La date de début doit être égale ou postérieure à la date actuelle.');
                }

                if (Carbon::parse($request->input('return_date'))->lte(Carbon::parse($request->input('rental_date')))) {
                    return redirect()->back()->with('error', 'La date de retour doit être après la date de début.');
                }

                $isCarAvailable = $this->checkCarAvailability($carId, $request->input('rental_date'), $request->input('return_date'));
                if (!$isCarAvailable) {
                    return redirect()->back()->with('error', 'La voiture est déjà réservée pour cette période.');
                }

                $days = Carbon::parse($request->input('rental_date'))->diffInDays($request->input('return_date')) + 1;
                $car = Car::findOrFail($carId);
                
                Rental::create([
                    'user_id' => $userId,
                    'car_id' => $carId,
                    'rental_date' => $request->input('rental_date'),
                    'return_date' => $request->input('return_date'),
                    'total_price' => $days * $car->price_per_day,
                    'status' => 'pending',
                ]);

                return redirect()->route('users.rentals', ['id' => $userId])->with('success', 'Réservation effectuée avec succès!');
            }
            
            // If it's a GET request, show the user-facing rental form
            $car = Car::findOrFail($carId);
            return view('rentals.user-create', compact('car'));
        }
        
        // Admin-facing rental creation
        $cars = Car::where('availability', 1)->get();
        $users = User::where('id', '!=', Auth::id())->get();
        $rental = new Rental(); // Créer une instance vide pour le formulaire
        return view('dashboard.rentals.create', compact('cars', 'users', 'rental'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:rental_date',
            'status' => 'required|in:pending,approved,completed,cancelled',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check car availability
        if (!$this->checkCarAvailability(
            $validated['car_id'],
            $validated['rental_date'],
            $validated['return_date']
        )) {
            return back()->with('error', 'La voiture n\'est pas disponible pour les dates sélectionnées.')->withInput();
        }

        // Create the rental with the provided total price
        $rental = Rental::create($validated);

        // Update car availability if status is approved
        if ($validated['status'] === 'approved') {
            $car = Car::findOrFail($validated['car_id']);
            $car->update(['availability' => 0]);
        }

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Location créée avec succès!');
    }

    public function show(Rental $rental)
    {
        return view('dashboard.rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $cars = Car::where('availability', 1)->orWhere('id', $rental->car_id)->get();
        $users = User::all();
        return view('dashboard.rentals.edit', compact('rental', 'cars', 'users'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after:rental_date',
            'status' => 'required|in:pending,approved,completed,cancelled',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if dates have changed or car has changed
        $datesChanged = $rental->rental_date != $validated['rental_date'] || 
                        $rental->return_date != $validated['return_date'];
        $carChanged = $rental->car_id != $validated['car_id'];

        // If dates or car changed, check availability
        if (($datesChanged || $carChanged) && 
            !$this->checkCarAvailability(
                $validated['car_id'],
                $validated['rental_date'],
                $validated['return_date'],
                $rental->id
            )
        ) {
            return back()->with('error', 'La voiture n\'est pas disponible pour les dates sélectionnées.')->withInput();
        }

        // Update the rental with the provided total price
        $rental->update($validated);

        // Update car availability based on status
        $car = $rental->car;
        if ($validated['status'] === 'approved') {
            $car->update(['availability' => 0]);
        } elseif (in_array($validated['status'], ['completed', 'cancelled'])) {
            $car->update(['availability' => 1]);
        }

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Location mise à jour avec succès!');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('dashboard.rentals.index')
            ->with('success', 'Location supprimée avec succès!');
    }

    /**
     * Update the status of a rental.
     *
     * @param  \App\Models\Rental  $rental
     * @param  string  $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Rental $rental, $status)
    {
        // Validate the status
        if (!in_array($status, ['pending', 'approved', 'completed', 'cancelled'])) {
            return back()->with('error', 'Statut invalide.');
        }

        // Update the status
        $rental->status = $status;
        $rental->save();

        // Update car availability if needed
        if ($status === 'completed' || $status === 'cancelled') {
            $rental->car->update(['availability' => 1]);
        } elseif ($status === 'approved') {
            $rental->car->update(['availability' => 0]);

            // Send voucher email to the user
            if ($rental->user) {
                try {
                    Mail::to($rental->user->email)->send(new RentalVoucherMail($rental));
                } catch (\Exception $e) {
                    // Log the error but don't fail the request
                    \Log::error('Failed to send rental voucher email: ' . $e->getMessage());
                }
            }
        }

        $statusMessages = [
            'pending' => 'Location marquée comme en attente',
            'approved' => 'Location approuvée avec succès',
            'completed' => 'Location marquée comme terminée',
            'cancelled' => 'Location annulée avec succès'
        ];

        return redirect()->route('dashboard.rentals.index')
            ->with('success', $statusMessages[$status] ?? 'Statut mis à jour avec succès');
    }

    /**
     * Check if a car is available for the given date range
     *
     * @param int $carId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $exceptRentalId
     * @return bool
     */
    private function checkCarAvailability($carId, $startDate, $endDate, $exceptRentalId = null)
    {
        $query = Rental::where('car_id', $carId)
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('rental_date', [$startDate, $endDate])
                  ->orWhereBetween('return_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('rental_date', '<=', $startDate)
                        ->where('return_date', '>=', $endDate);
                  });
            });

        if ($exceptRentalId) {
            $query->where('id', '!=', $exceptRentalId);
        }

        return $query->doesntExist();
    }
}
