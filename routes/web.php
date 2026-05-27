<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminPickupController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCatalogController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminWithdrawalController;
use App\Http\Controllers\CsrReportController;
use App\Http\Controllers\DriverController;
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
// Rute Dashboard
Route::get('/dashboard', function () {
    // Ambil 3 riwayat penjemputan terakhir milik user yang sedang login
    $recentPickups = \App\Models\Pickup::where('user_id', \Illuminate\Support\Facades\Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();

    // Kirim data $recentPickups ke tampilan dashboard yang sesuai
    if (\Illuminate\Support\Facades\Auth::user()->role === 'b2b_user') {
        return view('dashboard-b2b', compact('recentPickups'));
    }
    
    return view('dashboard', compact('recentPickups'));
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


    // Rute untuk Halaman Leaderboard B2C
    Route::get('/leaderboard', function () {
        // 1. Ambil 10 peringkat teratas dari pengguna B2C berdasarkan poin terbanyak
        $topUsers = User::where('role', 'b2c_user')
            ->orderBy('point_balance', 'desc')
            ->take(10)
            ->get();

        // 2. Hitung peringkat pengguna yang sedang login saat ini di antara seluruh B2C
        $allB2CUsers = User::where('role', 'b2c_user')
            ->orderBy('point_balance', 'desc')
            ->pluck('id')
            ->toArray();
            
        // Cari indeks ID user saat ini di dalam array (indeks dimulai dari 0, jadi kita +1)
        $currentUserRank = array_search(Auth::id(), $allB2CUsers) !== false ? array_search(Auth::id(), $allB2CUsers) + 1 : '-';

        return view('leaderboard', compact('topUsers', 'currentUserRank'));
    })->name('leaderboard');

    // Manajemen Alamat (Buku Alamat)
    Route::get('/alamat', [AddressController::class, 'edit'])->name('address.edit');
    Route::post('/alamat', [AddressController::class, 'store'])->name('address.store');
    Route::put('/alamat/{id}/primary', [AddressController::class, 'setPrimary'])->name('address.setPrimary');

    // Rute Pencairan Saldo untuk User (B2C / B2B)
    Route::get('/tarik-saldo', [WithdrawalController::class, 'create'])->name('withdrawals.create');
    Route::post('/tarik-saldo', [WithdrawalController::class, 'store'])->name('withdrawals.store');

    // Rute Laporan CSR (Khusus B2B)
    Route::get('/b2b/laporan-csr', [CsrReportController::class, 'index'])->name('b2b.csr');

    // Leaderboard Gamifikasi (B2C & B2B Dipisah)
    Route::get('/leaderboard', function () {
        // 1. Ambil 10 peringkat teratas B2C
        $topB2CUsers = App\Models\User::where('role', 'b2c_user')
            ->orderBy('point_balance', 'desc')
            ->take(10)
            ->get();

        // 2. Ambil 10 peringkat teratas B2B
        $topB2BUsers = App\Models\User::where('role', 'b2b_user')
            ->orderBy('point_balance', 'desc')
            ->take(10)
            ->get();

        // 3. Hitung peringkat pengguna yang sedang login berdasarkan role-nya sendiri
        $currentUser = Illuminate\Support\Facades\Auth::user();
        $currentUserRank = '-';

        if ($currentUser->role === 'b2c_user' || $currentUser->role === 'b2b_user') {
            $allUsersInRole = App\Models\User::where('role', $currentUser->role)
                ->orderBy('point_balance', 'desc')
                ->pluck('id')
                ->toArray();
            
            $rankIndex = array_search($currentUser->id, $allUsersInRole);
            $currentUserRank = $rankIndex !== false ? $rankIndex + 1 : '-';
        }

        return view('leaderboard', compact('topB2CUsers', 'topB2BUsers', 'currentUserRank', 'currentUser'));
    })->name('leaderboard');
});


Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/dashboard', [DriverController::class, 'index'])->name('dashboard');
    Route::post('/pickups/{id}/claim', [DriverController::class, 'claim'])->name('claim');
    Route::post('/pickups/{id}/start', [DriverController::class, 'start'])->name('start');
    Route::get('/pickups/{id}/detail', [DriverController::class, 'detail'])->name('detail');
    Route::post('/pickups/{id}/verify', [DriverController::class, 'verify'])->name('verify');
    Route::post('/pickups/{id}/report', [DriverController::class, 'report'])->name('report');
    Route::get('/history', [DriverController::class, 'history'])->name('history');
});

// ==========================================
// RUTE KHUSUS ADMINISTRATOR
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        // Hitung statistik keseluruhan sistem
        $totalUsers = User::whereIn('role', ['b2c_user', 'b2b_user'])->count(); 
        $totalPickups = Pickup::count();
        $pendingPickups = Pickup::where('status', 'pending')->count();
        
        // Ambil maksimal 3 permintaan penjemputan terbaru yang statusnya 'pending'
        $recentPendingPickups = Pickup::with('user')
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalPickups', 'pendingPickups', 'recentPendingPickups'));
    })->name('dashboard');

    // 👇 BAGIAN INI YANG DIUBAH (Hapus kata /admin dan admin.) 👇
    Route::get('/pickups', [AdminPickupController::class, 'index'])->name('pickups.index');
    Route::put('/pickups/{id}', [AdminPickupController::class, 'update'])->name('pickups.update');

    // Rute Kelola Pengguna Admin
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Rute Kelola Katalog Harga Admin
    Route::get('/catalogs', [AdminCatalogController::class, 'index'])->name('catalogs.index');
    Route::post('/catalogs', [AdminCatalogController::class, 'store'])->name('catalogs.store');
    Route::put('/catalogs/{id}', [AdminCatalogController::class, 'update'])->name('catalogs.update');
    Route::delete('/catalogs/{id}', [AdminCatalogController::class, 'destroy'])->name('catalogs.destroy');

    // Kelola Pencairan Saldo (Withdrawals) oleh Admin
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::put('/withdrawals/{id}', [AdminWithdrawalController::class, 'update'])->name('withdrawals.update');
});

require __DIR__.'/auth.php';