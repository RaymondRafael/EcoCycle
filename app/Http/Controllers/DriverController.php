<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    // Menampilkan halaman utama tugas kurir
    public function index(Request $request)
    {
        // Ambil parameter filter dari URL (?type=b2c atau ?type=b2b)
        $type = $request->query('type');

        // Mulai query dengan memanggil relasi user agar efisien (Eager Loading)
        $query = Pickup::with('user')->whereIn('status', ['pending', 'on_the_way']);

        // Kondisi jika filter dipilih
        if ($type === 'b2c') {
            $query->whereHas('user', function ($q) {
                $q->where('role', 'b2c_user');
            });
        } elseif ($type === 'b2b') {
            $query->whereHas('user', function ($q) {
                $q->where('role', 'b2b_user');
            });
        }

        $tasks = $query->orderBy('pickup_date', 'asc')->get();

        // =========================================================
        // FITUR AI ROUTE OPTIMIZATION (REAL-TIME GPS KURIR)
        // =========================================================
        // Kita sertakan juga status 'on_the_way' agar rute tidak hilang saat kurir sedang di jalan
        $activeTasks = $tasks->whereIn('status', ['pending', 'on_the_way']);
        $waypointsString = '';
        $destinationString = '';

        if ($activeTasks->count() > 0) {
            // Ambil pelanggan terakhir sebagai titik tujuan akhir (Destination)
            $lastTask = $activeTasks->last();
            
            // Prioritaskan pickup_address dari transaksi, jika kosong baru ambil dari profil user
            $lastAddress = $lastTask->pickup_address ?? ($lastTask->user->address . ', ' . ($lastTask->user->city ?? 'Bandung'));
            $destinationString = urlencode($lastAddress);
            
            // Susun semua pelanggan sebagai titik mampir (Waypoints)
            foreach ($activeTasks as $task) {
                $address = $task->pickup_address ?? ($task->user->address . ', ' . ($task->user->city ?? 'Bandung'));
                
                if (!empty(trim($address))) {
                    $waypointsString .= urlencode($address) . '|';
                }
            }

            $waypointsString = rtrim($waypointsString, '|'); // Hapus garis vertikal di akhir
        }

        // Kirim $waypointsString dan $destinationString ke tampilan view
        return view('driver.dashboard', compact('tasks', 'waypointsString', 'destinationString'));
    }

    // Mengubah status penjemputan (Mulai jalan / Selesai)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:on_the_way,completed,cancelled'
        ]);

        $pickup = Pickup::findOrFail($id);
        
        // Update status penjemputan
        $pickup->update([
            'status' => $request->status
        ]);

        // Catatan: Untuk penambahan poin saat status 'completed', 
        // akan kita buatkan modul timbangan khusus setelah halaman ini beres.

        return back()->with('success', 'Status penjemputan berhasil diperbarui!');
    }


    // Menampilkan halaman form penimbangan
    public function weigh($id)
    {
        $task = Pickup::with('user')->findOrFail($id);
        $catalogs = \App\Models\Catalog::all();
        
        return view('driver.weigh', compact('task', 'catalogs'));
    }

    // Memproses data timbangan, menghitung poin, dan menyelesaikan order
    public function processWeigh(Request $request, $id)
    {
        $request->validate([
            'weight_plastic' => 'nullable|numeric|min:0',
            'weight_paper' => 'nullable|numeric|min:0',
            'weight_metal' => 'nullable|numeric|min:0',
            'weight_glass' => 'nullable|numeric|min:0',
        ]);

        $task = Pickup::with('user')->findOrFail($id);
        $user = $task->user;

        // Ambil harga dari database
        $plastic = \App\Models\Catalog::where('name', 'Plastik')->first();
        $paper = \App\Models\Catalog::where('name', 'Kertas')->first();
        $metal = \App\Models\Catalog::where('name', 'Logam')->first();
        $glass = \App\Models\Catalog::where('name', 'Kaca')->first();

        // Deteksi apakah pelanggan ini akun Bisnis (B2B) atau Personal (B2C)
        $isB2B = $user->role === 'b2b_user';

        // Kalkulasi Total Poin
        $totalPoints = 0;
        $totalPoints += ($request->weight_plastic ?? 0) * ($isB2B ? $plastic->price_b2b : $plastic->price_b2c);
        $totalPoints += ($request->weight_paper ?? 0) * ($isB2B ? $paper->price_b2b : $paper->price_b2c);
        $totalPoints += ($request->weight_metal ?? 0) * ($isB2B ? $metal->price_b2b : $metal->price_b2c);
        $totalPoints += ($request->weight_glass ?? 0) * ($isB2B ? $glass->price_b2b : $glass->price_b2c);

        // Update data pickup
        $task->update([
            'weight_plastic' => $request->weight_plastic ?? 0,
            'weight_paper' => $request->weight_paper ?? 0,
            'weight_metal' => $request->weight_metal ?? 0,
            'weight_glass' => $request->weight_glass ?? 0,
            'total_points_earned' => $totalPoints,
            'status' => 'completed'
        ]);

        // Tambahkan poin ke saldo dompet pelanggan
        $user->increment('point_balance', $totalPoints);

        return redirect()->route('driver.dashboard')->with('success', 'Penjemputan selesai! ' . number_format($totalPoints, 0, ',', '.') . ' Poin telah dikirim ke pelanggan.');
    }


    // Menampilkan riwayat tugas kurir (Selesai & Batal)
    public function history(Request $request)
    {
        // Ambil parameter filter dari URL (?type=b2c atau ?type=b2b)
        $type = $request->query('type');

        $query = Pickup::with('user')->whereIn('status', ['completed', 'cancelled']);

        // Terapkan filter berdasarkan jenis akun
        if ($type === 'b2c') {
            $query->whereHas('user', function ($q) {
                $q->where('role', 'b2c_user');
            });
        } elseif ($type === 'b2b') {
            $query->whereHas('user', function ($q) {
                $q->where('role', 'b2b_user');
            });
        }

        $historyTasks = $query->orderBy('updated_at', 'desc')->get();

        return view('driver.history', compact('historyTasks'));
    }
}