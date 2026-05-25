<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    // Menampilkan halaman form penjemputan
    public function create()
    {
        // 1. Ambil semua alamat milik user yang sedang login
        $addresses = \Illuminate\Support\Facades\Auth::user()->addresses()->orderBy('is_primary', 'desc')->get();
        
        // 2. Ambil semua data dari tabel catalogs (Katalog Harga)
        $catalogs = \App\Models\Catalog::all(); 
        
        // 3. Kirim kedua variabel tersebut ke dalam view b2c/b2b penjemputan
        return view('pickup.create', compact('addresses', 'catalogs'));
    }

    // Menyimpan data penjemputan ke database
    public function store(Request $request)
    {
        $request->validate([
            'pickup_date' => 'required|date|after:today',
            'address_id' => 'required|exists:user_addresses,id', // Validasi alamat yang dipilih
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Cari data alamat lengkap berdasarkan ID yang dipilih user
        $selectedAddress = \App\Models\UserAddress::where('id', $request->address_id)
                            ->where('user_id', $user->id)
                            ->firstOrFail();

        // Rangkai alamat menjadi satu kalimat lengkap untuk disimpan sebagai riwayat permanen
        $fullAddressText = $selectedAddress->label_name . ' - ' . $selectedAddress->full_address . ', Kota ' . $selectedAddress->city;
        if($selectedAddress->pic_name) {
            $fullAddressText .= ' (PIC: ' . $selectedAddress->pic_name . ' - ' . $selectedAddress->phone . ')';
        } else {
            $fullAddressText .= ' (Telp: ' . $selectedAddress->phone . ')';
        }

        \App\Models\Pickup::create([
            'user_id' => $user->id,
            'pickup_date' => $request->pickup_date,
            'pickup_address' => $fullAddressText, // Simpan teks alamat lengkapnya
            'status' => 'pending',
            'total_points_earned' => 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Jadwal penjemputan armada berhasil dibuat!');
    }
}