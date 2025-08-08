<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function Cars()
    {
        $cars = Car::all(); // Récupère tous les voitures

        return view('cars', ['cars' => $cars]); // Envoie les cars à la vue
    }

    public function detail($id) 
    {
        $car = Car::find($id);
        $rentals = $car->rentals()->where('status', '!=', 3)->get();
    
        return view('detailCars', compact('car', 'rentals'));
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

        return redirect()->route('dashboard.cars')->with('success', 'Voiture ajoutée avec succès!');
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
}
