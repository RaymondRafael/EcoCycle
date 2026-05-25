<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Menampilkan daftar semua pengguna
    public function index()
    {
        // Ambil semua user kecuali akun admin yang sedang login, urutkan dari yang paling baru mendaftar
        $users = User::where('id', '!=', auth()->id())
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return view('admin.users.index', compact('users'));
    }

    // Menghapus akun pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus pengguna dari database
        $user->delete();

        return back()->with('success', 'Data akun pengguna berhasil dihapus dari sistem.');
    }
}