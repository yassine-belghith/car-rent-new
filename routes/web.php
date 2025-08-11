<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use App\Http\Controllers\TransferBookingController;
use App\Http\Controllers\LocationController;


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

// Regular authenticated routes
Route::middleware(['auth'])->group(function () {
    // User rental history
    Route::get('/users/rentals/{user}', [App\Http\Controllers\UserController::class, 'rentals'])
        ->name('users.rentals');

        
    // Authentication routes


    // User profile routes
    
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    
    // User preferences
    Route::get('/preferences', [UserController::class, 'showPreferences'])->name('preferences.show');
    Route::put('/preferences', [UserController::class, 'updatePreferences'])->name('preferences.update');
    Route::post('/preferences/avatar', [UserController::class, 'updateAvatar'])->name('preferences.avatar');
    Route::delete('/preferences/avatar/remove', [UserController::class, 'removeAvatar'])->name('preferences.avatar.remove');
});
    
    // Transfer bookings
    Route::get('/transfers/my-transfers', [TransferBookingController::class, 'index'])->name('transfers.my');
    Route::get('/transfers/book', [TransferBookingController::class, 'create'])->name('transfers.book');
    Route::post('/transfers', [TransferBookingController::class, 'store'])->name('transfers.store');
    Route::get('/transfers/{transfer}/invoice', [TransferBookingController::class, 'downloadInvoice'])->name('transfers.invoice');
    
    // Car rentals
    Route::post('/rentals/store/{carId}', [RentalController::class, 'userStore'])->name('rental.user.store');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');


// Admin only routes
Route::middleware([
    \App\Http\Middleware\AuthMiddleware::class,
    \App\Http\Middleware\AdminMiddleware::class
])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Dashboard routes
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    
    // Cars list
    Route::get('/cars', [DashboardController::class, 'cars'])->name('cars.index');
    
    // Rentals list
    Route::get('/rentals', [DashboardController::class, 'rentals'])->name('rentals.index');
    
    // Make/Remove Admin
    Route::put('/users/{id}/make-admin', [UserController::class, 'makeAdmin'])->name('users.makeAdmin');
    Route::put('/users/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('users.removeAdmin');
    
    // Car management
    Route::get('/cars/create', [PageController::class, 'createCar'])->name('cars.page.create');
    Route::post('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::get('/cars/edit/{id}', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/update/{id}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/delete/{id}', [CarController::class, 'destroy'])->name('cars.delete');
    
    // Car maintenance
    Route::prefix('cars/{car}')->name('cars.')->group(function () {
        Route::resource('maintenances', App\Http\Controllers\Admin\MaintenanceController::class)->names('maintenances');
    });
    
    // Driver management
    Route::put('/users/{id}/make-driver', [UserController::class, 'makeDriver'])->name('users.makeDriver');
    Route::put('/users/{id}/remove-driver', [UserController::class, 'removeDriver'])->name('users.removeDriver');

    // Contact Messages
    Route::prefix('contact-messages')->name('contact.messages.')->group(function() {
        Route::get('/', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'index'])->name('index');
        Route::get('/{contactMessage}', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'show'])->name('show');
        Route::get('/{contactMessage}/edit', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'edit'])->name('edit');
        Route::post('/{contactMessage}/toggle-read', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'toggleReadStatus'])->name('toggle-read');
        Route::delete('/{contactMessage}', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'destroy'])->name('destroy');
        Route::delete('/', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'destroyMultiple'])->name('destroy-multiple');
        Route::get('/export', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'export'])->name('export');
        Route::get('/stats', [\App\Http\Controllers\Dashboard\ContactMessageController::class, 'stats'])->name('stats');
    });

    // Users list
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');

    // Rentals Management
    Route::prefix('rentals')->name('rentals.')->group(function() {
        Route::get('/', [RentalController::class, 'index'])->name('index');
        Route::get('/create', [RentalController::class, 'create'])->name('create');
        Route::post('/', [RentalController::class, 'store'])->name('store');
        Route::get('/{rental}', [RentalController::class, 'show'])->name('show');
        Route::get('/{rental}/edit', [RentalController::class, 'edit'])->name('edit');
        Route::put('/{rental}', [RentalController::class, 'update'])->name('update');
        Route::put('/{rental}/status/{status}', [RentalController::class, 'updateStatus'])->name('status');
        Route::delete('/{rental}', [RentalController::class, 'destroy'])->name('destroy');
        
        // Old routes for backward compatibility
        Route::put('/status/{status}/{id}', [RentalController::class, 'updateStatus'])->name('status.old');
        Route::delete('/delete/{id}', [RentalController::class, 'destroy'])->name('delete.old');
    });
    


    // Destinations Management
    Route::prefix('destinations')->name('destinations.')->group(function () {
        Route::resource('/', DestinationController::class)->parameters(['' => 'destination']);
    });

    // Drivers Management
    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::resource('/', DriverController::class)->parameters(['' => 'driver']);
    });

    // Transfers Management
    Route::prefix('transfers')->name('transfers.')->group(function () {
        Route::resource('/', TransferController::class)->parameters(['' => 'transfer']);
    });
});

// Driver routes (separate from admin routes)
Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Driver\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transfers/{transfer}', [DriverDashboardController::class, 'show'])->name('transfers.show');
    Route::post('/transfers/{transfer}/confirm', [DriverDashboardController::class, 'confirm'])->name('transfers.confirm');
    Route::post('/transfers/{transfer}/decline', [DriverDashboardController::class, 'decline'])->name('transfers.decline');
});

// Public routes (no authentication required)
Route::get('/locations/search', [LocationController::class, 'search'])->name('locations.search');
Route::get('/', [CarController::class, 'acceuil'])->name('car.acceuil');

// Routes pour le formulaire de contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'showContactForm'])->name('contact.form');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'sendEmail'])->name('contact.submit');
Route::get('/unsubscribe/contact', [\App\Http\Controllers\ContactController::class, 'unsubscribe'])->name('unsubscribe.contact');
Route::get('/cars', [CarController::class, 'cars'])->name('car.cars');
Route::get('/cars/search', [CarController::class, 'search'])->name('car.search');
Route::get('/register', [PageController::class, 'register'])->name('page.register');
Route::post('/register', [UserController::class ,'register'])->name('user.register');

// Temp fix for old login route
Route::get('/login-old', function () { return redirect()->route('login'); })->name('page.login');

// Authentication routes
Route::get('login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'store'])->name('login.perform')->middleware('guest');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');
Route::get('/cars/detail/{id}', [CarController::class, 'detail'])->name('cars.detail');
Route::get('/api/available-drivers', [\App\Http\Controllers\CarController::class, 'getAvailableDrivers'])->name('api.available-drivers');