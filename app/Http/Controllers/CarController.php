<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{

    public function detail($id) 
    {
        $car = Car::find($id);
        $rentals = $car->rentals()->where('status', '!=', 3)->get();
        $drivers = User::where('role', 'driver')->get();
    
        return view('detailCars', compact('car', 'rentals', 'drivers'));
    }
    

    public function create(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'availability' => 'required|in:0,1',
            'registration_number' => 'required|string|max:20|unique:cars,registration_number',
            'description' => 'nullable|string',
        ]);

        // Handle file uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create the car with the first image path (or empty string if no images)
        $car = Car::create([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : '',
            'availability' => $validated['availability'],
            'registration_number' => $validated['registration_number'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('dashboard.cars.index')->with('success', 'Voiture ajoutée avec succès!');
    }

    public function edit($id)
    {
        $car = Car::find($id);

        return view('dashboard.editCar', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        $car->update($request->all());

        return redirect()->route('dashboard.cars')->with('success', 'Voiture mise à jour avec succès!');
    }

    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();

        return redirect()->route('dashboard.cars')->with('success', 'Voiture supprimée avec succès!');
    }

    public function acceuil() 
    {
        $cars = Car::take(4)->get();
    
        return view('welcome', ['cars' => $cars]);
    }

    public function cars()
    {
        $cars = Car::all();
        return view('cars', ['cars' => $cars]);
    }

    public function search(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|array',
            'type.*' => 'string|in:compact,sedan,berline,pickup,suv',
            'capacity' => 'nullable|array',
            'capacity.*' => 'integer|in:2,4,5',
            'start_date' => 'nullable|date|required_with:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_with:start_date',
        ]);

        $query = Car::query();

        // Search by location (brand or model)
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function ($q) use ($location) {
                $q->where('brand', 'like', "%{$location}%")
                  ->orWhere('model', 'like', "%{$location}%");
            });
        }

        // Filter by vehicle type
        if ($request->filled('type')) {
            $query->whereIn('type', $request->input('type'));
        }

        // Filter by capacity
        if ($request->filled('capacity')) {
            $query->whereIn('seats', $request->input('capacity'));
        }

        // Filter by date availability
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereDoesntHave('rentals', function ($q) use ($startDate, $endDate) {
                $q->where(function ($query) use ($startDate, $endDate) {
                    $query->where('rental_date', '<=', $endDate)
                          ->where('return_date', '>=', $startDate);
                });
            });
        }

        $cars = $query->get();

        return view('cars', [
            'cars' => $cars,
            'search' => $request->input('location'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);
    }

    public function getAvailableDrivers(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        Log::info('Fetching available drivers for dates:', ['start' => $startDate, 'end' => $endDate]);

        $query = User::where('is_driver', true)
            ->whereDoesntHave('assignedRentals', function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('rental_date', '<', $endDate)
                      ->where('return_date', '>', $startDate);
                });
            });
        
        Log::info('Driver Availability Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

        $availableDrivers = $query->get();

        Log::info('Found ' . $availableDrivers->count() . ' available drivers.');

        return response()->json($availableDrivers);
    }
}
