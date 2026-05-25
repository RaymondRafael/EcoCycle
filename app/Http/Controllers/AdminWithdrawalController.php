<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    /**
     * Menampilkan semua daftar permintaan pencairan dana di halaman Admin.
     */
    public function index()
    {
        // Mengambil semua data penarikan beserta profil user terkait, diurutkan dari yang terbaru
        $withdrawals = Withdrawal::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Memproses persetujuan (Selesai Transfer) atau penolakan permintaan pencairan.
     */
    public function update(Request $request, $id)
    {
        // Validasi input status dari form admin
        $request->validate([
            'status' => 'required|in:success,rejected'
        ]);

        $withdrawal = Withdrawal::findOrFail($id);

        // Memastikan transaksi yang sudah diproses tidak bisa diubah lagi demi keamanan data
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah selesai diproses sebelumnya.');
        }

        // LOGIKA PENTING: Jika Admin memilih "Tolak" (rejected), kembalikan poin saldo ke user secara utuh
        if ($request->status === 'rejected') {
            $withdrawal->user->increment('point_balance', $withdrawal->amount_points);
        }

        // Perbarui status transaksi di database
        $withdrawal->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pencairan saldo berhasil diperbarui!');
    }
}