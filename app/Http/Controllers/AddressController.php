<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // Menampilkan daftar alamat dan form tambah
    public function edit()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_primary', 'desc')->get();
        return view('address.edit', compact('addresses'));
    }

    // Menyimpan alamat baru
    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'label_name' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'full_address' => 'required|string|max:500',
        ];

        // Jika B2B, wajib isi nama PIC
        if ($user->role === 'b2b_user') {
            $rules['pic_name'] = 'required|string|max:100';
        }

        $request->validate($rules);

        // Cek apakah user belum punya alamat sama sekali
        $isFirstAddress = $user->addresses()->count() === 0;

        UserAddress::create([
            'user_id' => $user->id,
            'label_name' => $request->label_name,
            'pic_name' => $request->pic_name ?? $user->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'full_address' => $request->full_address,
            'postal_code' => $request->postal_code,
            'is_primary' => $isFirstAddress ? true : false, // Jadikan utama jika ini alamat pertama
        ]);

        return back()->with('success', 'Alamat baru berhasil ditambahkan ke daftar!');
    }

    // Mengatur alamat menjadi utama
    public function setPrimary($id)
    {
        $user = Auth::user();
        
        // Reset semua alamat user menjadi bukan utama
        $user->addresses()->update(['is_primary' => false]);
        
        // Jadikan alamat yang dipilih sebagai utama
        UserAddress::where('id', $id)->where('user_id', $user->id)->update(['is_primary' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah!');
    }
}