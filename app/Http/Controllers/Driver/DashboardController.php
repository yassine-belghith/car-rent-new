<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DriverResponseNotification;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        $transfers = Transfer::where('driver_id', $driver->id)
                             ->orderBy('pickup_datetime', 'asc')
                             ->paginate(10);

        return view('driver.dashboard', compact('transfers'));
    }

    public function confirm(Request $request, Transfer $transfer)
    {
        // Ensure the logged-in user is the assigned driver
        if ($transfer->driver_id !== Auth::id()) {
            return redirect()->route('driver.dashboard')->with('error', 'Accès non autorisé.');
        }

        $transfer->update(['driver_confirmation_status' => 'confirmed']);

        // Notify administrators
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new DriverResponseNotification($transfer->fresh()));
        }

        return redirect()->route('driver.dashboard')->with('success', 'Transfert confirmé avec succès.');
    }

    public function show(Transfer $transfer)
    {
        // Ensure the logged-in user is the assigned driver
        if ($transfer->driver_id !== Auth::id()) {
            return redirect()->route('driver.dashboard')->with('error', 'Accès non autorisé.');
        }

        return view('driver.transfers.show', compact('transfer'));
    }

    public function decline(Request $request, Transfer $transfer)
    {
        // Ensure the logged-in user is the assigned driver
        if ($transfer->driver_id !== Auth::id()) {
            return redirect()->route('driver.dashboard')->with('error', 'Accès non autorisé.');
        }

        $transfer->update(['driver_confirmation_status' => 'declined']);

        // Notify administrators
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new DriverResponseNotification($transfer->fresh()));
        }

        return redirect()->route('driver.dashboard')->with('success', 'Transfert refusé.');
    }
}