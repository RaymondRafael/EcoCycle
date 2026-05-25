<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;

class AdminPickupController extends Controller
{
    // Menampilkan semua daftar penjemputan
    public function index()
    {
        // Ambil semua data pickup beserta data usernya, urutkan dari yang terbaru
        $pickups = Pickup::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('admin.pickups.index', compact('pickups'));
    }

    // Memproses perubahan status dan pemberian poin
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,on_the_way,completed,cancelled',
            'points' => 'nullable|numeric|min:0'
        ]);

        $pickup = Pickup::findOrFail($id);
        
        // Simpan status lama untuk mengecek apakah ini baru saja diselesaikan
        $oldStatus = $pickup->status;
        $newPoints = $request->points ?? 0;

        // Update data penjemputan
        $pickup->update([
            'status' => $request->status,
            'total_points_earned' => $newPoints,
        ]);

        // Jika statusnya BERUBAH menjadi 'completed' (Selesai), tambahkan poin ke saldo User
        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            $pickup->user->increment('point_balance', $newPoints);
        }

        return back()->with('success', 'Status penjemputan berhasil diperbarui!');
    }
}