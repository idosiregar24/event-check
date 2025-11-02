<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        // Dashboard utama super admin
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Event
        Route::resource('/events', SuperAdminController::class)->except(['show']);

        // Tambah Admin per Event
        Route::get('/events/{id}/assign-admin', [SuperAdminController::class, 'assignAdminForm'])->name('assignAdminForm');
        Route::post('/events/{id}/assign-admin', [SuperAdminController::class, 'assignAdminStore'])->name('assignAdminStore');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin → list event yang ditangani
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Daftar tamu per event
        Route::get('/events/{event}/guests', [AdminController::class, 'guests'])->name('events.guests');
    });



Route::middleware(['auth', 'role:guest'])->group(function () {
    Route::get('/guest/dashboard', fn() => view('guest.dashboard'));
});


Route::get('/register/{event}', [GuestController::class, 'showForm'])->name('guest.form');
Route::post('/register/{event}', [GuestController::class, 'store'])->name('guest.store');


Route::get('/guest/check/{qr_token}', [GuestController::class, 'check'])->name('guest.check');

Route::get('/events/{id}/guest-seats', [EventController::class, 'guestSeats'])->name('admin.events.guests_seats');
?>
