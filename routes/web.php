<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

// Panggil Model yang dibutuhkan untuk hitungan statistik di Dashboard Admin
use App\Models\User;
use App\Models\Pickup;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// RUTE PENGGUNA BIASA (B2C / B2B)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Halaman Riwayat
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history.index');

    // Rute untuk Penjemputan Sampah (Pickup)
    Route::get('/jemput/buat', [PickupController::class, 'create'])->name('pickup.create');
    Route::post('/jemput', [PickupController::class, 'store'])->name('pickup.store');
});

// ==========================================
// RUTE KHUSUS ADMINISTRATOR
// ==========================================
// Rute ini dilindungi oleh middleware 'auth' (harus login) DAN 'admin' (harus role admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        // Hitung B2C dan B2B user sesuai dengan role baru
        $totalUsers = User::whereIn('role', ['b2c_user', 'b2b_user'])->count(); 
        
        // Hitung total semua penjemputan dan yang masih pending
        $totalPickups = Pickup::count();
        $pendingPickups = Pickup::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalPickups', 'pendingPickups'));
    })->name('dashboard');

    // Nanti kamu bisa menambahkan rute admin lainnya di sini, contoh:
    // Route::get('/kelola-pickup', [AdminController::class, 'pickups'])->name('pickups');
});

require __DIR__.'/auth.php';