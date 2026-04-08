<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    // Menampilkan halaman form penjadwalan
    public function create()
    {
        return view('pickup.create');
    }

    // Memproses data form dan menyimpannya ke database
    public function store(Request $request)
    {
        // 1. Validasi input (wajib diisi, dan minimal hari ini/besok)
        $request->validate([
            'pickup_date' => 'required|date|after:now',
        ], [
            'pickup_date.required' => 'Tanggal dan waktu penjemputan wajib diisi.',
            'pickup_date.after' => 'Waktu penjemputan tidak boleh di masa lalu.',
        ]);

        // 2. Simpan ke database
        Pickup::create([
            'user_id' => Auth::id(),
            'pickup_date' => $request->pickup_date,
            'status' => 'pending',
            'total_points_earned' => 0, // Poin awal 0, nanti diisi oleh admin/driver
        ]);

        // 3. Arahkan pengguna ke halaman riwayat dengan pesan sukses
        return redirect()->route('history.index')->with('success', 'Hore! Permintaan penjemputanmu berhasil dijadwalkan. Mitra kami akan segera memprosesnya.');
    }
}