<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransferRequestReceived;
use App\Mail\AdminTransferRequestNotification;

class TransferBookingController extends Controller
{
    /**
     * Store a newly created transfer booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Transfer::class);
        $validatedData = $request->validate([
            'pickup_location_id' => 'required|exists:destinations,id',
            'dropoff_location_id' => 'required|exists:destinations,id|different:pickup_location_id',
            'pickup_datetime' => 'required|date|after:now',
            'passenger_count' => 'required|integer|min:1',
            'luggage_count' => 'required|integer|min:0',
            'airline' => 'nullable|string|max:255',
            'flight_number' => 'nullable|string|max:255',
            'special_instructions' => 'nullable|string',
        ]);
    
        $validatedData['user_id'] = Auth::id();
        $validatedData['reference_number'] = 'TRN-' . strtoupper(uniqid());
        $validatedData['status'] = 'pending';
        $validatedData['price'] = 0; // Admin will set the price
    
        $transfer = Transfer::create($validatedData);
    
        // Send confirmation email to the user
        Mail::to($transfer->user)->send(new TransferRequestReceived($transfer));

        // Send notification email to admin
        // Send notification email to admin
        $adminEmail = env('ADMIN_EMAIL');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new AdminTransferRequestNotification($transfer));
        }
    
        return redirect()->route('transfers.my')
                         ->with('success', 'Votre demande de transfert a été soumise avec succès. Nous vous contacterons bientôt pour la confirmation et le prix.');
    }
    /**
     * Display a listing of the user's transfer bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', Transfer::class);
        $transfers = Transfer::where('user_id', Auth::id())
                             ->with(['pickupLocation', 'dropoffLocation', 'driver', 'car'])
                             ->latest()
                             ->paginate(10);

        return view('transfers.my-transfers', compact('transfers'));
    }

    /**
     * Show the form for creating a new transfer booking.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Transfer::class);
        $destinations = Destination::where('is_active', true)->orderBy('name')->get();
        return view('transfers.book', compact('destinations'));
    }
}
