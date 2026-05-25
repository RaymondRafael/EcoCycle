<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CsrReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan halaman ini hanya bisa diakses oleh akun B2B
        if ($user->role !== 'b2b_user') {
            return redirect()->route('dashboard')->with('error', 'Halaman ini khusus untuk Mitra Bisnis/UMKM.');
        }

        // Ambil data penjemputan yang sudah selesai
        $completedPickups = Pickup::where('user_id', $user->id)
                                  ->where('status', 'completed')
                                  ->get();

        $totalPickups = $completedPickups->count();
        $totalPointsEarned = $completedPickups->sum('total_points_earned');

        // Simulasi perhitungan dampak lingkungan (Bisa disesuaikan rumusnya nanti)
        // Misal: 1000 Poin setara dengan 1 Kg limbah yang terkelola
        $wasteManagedKg = $totalPointsEarned / 1000; 
        
        // Misal: 1 Kg sampah yang didaur ulang mencegah 2.5 Kg emisi CO2
        $carbonReducedKg = $wasteManagedKg * 2.5;

        return view('b2b.csr-report', compact(
            'user', 
            'totalPickups', 
            'totalPointsEarned', 
            'wasteManagedKg', 
            'carbonReducedKg'
        ));
    }
}