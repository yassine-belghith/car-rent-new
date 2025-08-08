<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use App\Http\Controllers\TransferBookingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([\App\Http\Middleware\AuthMiddleware::class])->group(function () {
    // Les routes qui nécessitent l'authentification vont ici
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashbord/cars', [DashboardController::class, 'cars'])->name('dashboard.cars');
    Route::get('/dashboard/cars/create', [PageController::class, 'createCar'])->name('page.createCar');
    Route::post('/dashboard/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::get('/dashboard/cars/edit/{id}',[CarController::class, 'edit'])->name('cars.edit');
    Route::put('/dashboard/cars/update/{id}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/dashboard/cars/delete/{id}', [CarController::class, 'destroy'])->name('cars.delete');

    // Routes pour la gestion de l'entretien des voitures
    Route::prefix('dashboard/cars/{car}')->name('dashboard.cars.')->group(function () {
        Route::resource('maintenances', App\Http\Controllers\Admin\MaintenanceController::class)->names('maintenances');
    });
    Route::get('/dashboard/users', [DashboardController::class ,'users'])->name('dashboard.users');
    Route::put('/dashboard/users/role/admin/{id}', [UserController::class ,'makeAdmin'])->name('user.makeAdmin');
    Route::put('/users/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('user.removeAdmin');
    Route::put('/users/{id}/make-driver', [UserController::class, 'makeDriver'])->name('user.makeDriver');
    Route::put('/users/{id}/remove-driver', [UserController::class, 'removeDriver'])->name('user.removeDriver');

    // Routes for Drivers
    Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
        Route::get('/transfers/{transfer}', [DriverDashboardController::class, 'show'])->name('transfers.show');
        Route::post('/transfers/{transfer}/confirm', [DriverDashboardController::class, 'confirm'])->name('transfers.confirm');
        Route::post('/transfers/{transfer}/decline', [DriverDashboardController::class, 'decline'])->name('transfers.decline');
    });

    // Routes pour les messages de contact
    Route::prefix('dashboard/contact-messages')->name('dashboard.contact-messages.')->group(function() {
        Route::get('/', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'index'])->name('index');
        Route::get('/{contactMessage}', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'show'])->name('show');
        Route::get('/{contactMessage}/edit', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'edit'])->name('edit');
        Route::post('/{contactMessage}/toggle-read', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'toggleReadStatus'])->name('toggle-read');
        Route::delete('/{contactMessage}', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'destroy'])->name('destroy');
        Route::delete('/', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::get('/export', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'export'])->name('export');
        Route::get('/stats', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'stats'])->name('stats');
    });

    // Routes des locations avec le préfixe dashboard/rentals
    // Routes principales pour les locations (avec préfixe dashboard/rentals)
    Route::prefix('dashboard/rentals')->name('dashboard.rentals.')->group(function() {
        Route::get('/', [RentalController::class, 'index'])->name('index');
        Route::get('/create', [RentalController::class, 'create'])->name('create');
        Route::post('/', [RentalController::class, 'store'])->name('store');
        
        // Route avec nom pour le dashboard
        Route::get('/{rental}', [RentalController::class, 'show'])->name('show');
             
        Route::get('/{rental}/edit', [RentalController::class, 'edit'])->name('edit');
        Route::put('/{rental}', [RentalController::class, 'update'])->name('update');
        Route::put('/{rental}/status/{status}', [RentalController::class, 'updateStatus'])->name('status');
        Route::delete('/{rental}', [RentalController::class, 'destroy'])->name('destroy');
        
        // Anciennes routes pour la rétrocompatibilité
        Route::put('/status/{status}/{id}', [RentalController::class, 'updateStatus'])->name('status.old');
        Route::delete('/delete/{id}', [RentalController::class, 'destroy'])->name('delete.old');
    });
    
    // Alias pour la compatibilité avec les anciennes références
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');

    // Routes pour la gestion des destinations
    Route::prefix('dashboard/destinations')->name('dashboard.destinations.')->group(function () {
        Route::resource('/', DestinationController::class)->parameters(['' => 'destination']);
    });

    // Routes pour la gestion des chauffeurs
    Route::prefix('dashboard/drivers')->name('dashboard.drivers.')->group(function () {
        Route::resource('/', DriverController::class)->parameters(['' => 'driver']);
    });

    // Routes pour la gestion des transferts
    Route::prefix('dashboard/transfers')->name('dashboard.transfers.')->group(function () {
        Route::resource('/', TransferController::class)->parameters(['' => 'transfer']);
    });

    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

    // Routes pour le profil utilisateur
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Routes pour les préférences utilisateur
    Route::get('/preferences', [UserController::class, 'showPreferences'])->name('preferences.show');
    Route::put('/preferences', [UserController::class, 'updatePreferences'])->name('preferences.update');
    Route::post('/preferences/avatar', [UserController::class, 'updateAvatar'])->name('preferences.avatar');
    Route::delete('/preferences/avatar/remove', [UserController::class, 'removeAvatar'])->name('preferences.avatar.remove');
    
    // Routes for Transfer Booking by clients
    Route::get('/transfers/book', [TransferBookingController::class, 'create'])->name('transfers.book');
    Route::post('/transfers', [TransferBookingController::class, 'store'])->name('transfers.store');
    Route::get('/my-transfers', [TransferBookingController::class, 'index'])->name('transfers.my');

    // Routes pour les locations utilisateur
    Route::get('/users/rentals/{id}', [UserController::class, 'rentals'])->name('users.rentals');
    Route::post('/rentals/create/{carId}', [RentalController::class, 'create'])->name('rental.create');
});

// Les autres routes ici (qui ne nécessitent pas d'authentification)

Route::get('/', [CarController::class, 'acceuil'])->name('car.acceuil');

// Routes pour le formulaire de contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'showContactForm'])->name('contact.form');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'sendEmail'])->name('contact.submit');
Route::get('/unsubscribe/contact', [\App\Http\Controllers\ContactController::class, 'unsubscribe'])->name('unsubscribe.contact');
Route::get('/cars', [CarController::class, 'cars'])->name('car.cars');
Route::get('/register', [PageController::class, 'register'])->name('page.register');
Route::get('/login', [PageController::class, 'login'])->name('page.login');
Route::post('/register', [UserController::class ,'register'])->name('user.register');
Route::post('/login', [UserController::class ,'login'])->name('user.login');
Route::get('/cars/detail/{id}', [CarController::class, 'detail'])->name('cars.detail');