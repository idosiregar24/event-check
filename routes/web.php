<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CheckinController;
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


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/check', [GuestController::class, 'check'])->name('guest.check');
    Route::post('/check', [GuestController::class, 'check'])->name('guest.check');
});

// Cetak Pdf
Route::get('/admin/events/{id}/guests/pdf', [GuestController::class, 'exportPdf'])->name('guests.pdf');
Route::get('/admin/events/{id}/qr', [GuestController::class, 'generateQr'])
    ->name('generate.qr');
Route::get('/events/{id}/guest-seats', [EventController::class, 'guestSeats'])->name('admin.events.guests_seats');

// Form check-in (setelah scan QR)
Route::get('/checkin/form', [CheckinController::class, 'showForm'])->name('checkin.form');


// Submit form untuk ubah status
Route::post('/checkin/submit', [CheckinController::class, 'submit'])->name('checkin.submit');

Route::post('/checkin/cari-nim', [CheckinController::class, 'cariNim'])->name('checkin.cariNim');
Route::post('/checkin/submit', [CheckinController::class, 'submit'])->name('checkin.submit');


?>
