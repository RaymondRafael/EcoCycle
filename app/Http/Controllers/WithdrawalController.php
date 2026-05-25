<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    // Menampilkan halaman form penarikan saldo
    public function create()
    {
        return view('withdrawals.create');
    }

    // Memproses permintaan penarikan saldo
    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input Form
        $request->validate([
            'amount_points' => ['required', 'integer', 'min:10000', 'max:' . $user->point_balance],
            'payment_method' => ['required', 'string', 'in:DANA,OVO,GOPAY,LINKAJA,BANK BCA,BANK MANDIRI'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
        ], [
            'amount_points.max' => 'Saldo Poin Anda tidak mencukupi untuk melakukan penarikan ini.',
            'amount_points.min' => 'Minimal penarikan saldo adalah 10.000 Poin.',
        ]);

        // 2. Potong Saldo Poin Pengguna Terlebih Dahulu (Mengunci Saldo Virtual)
        $user->decrement('point_balance', $request->amount_points);

        // 3. Simpan Permintaan ke Tabel Withdrawals dengan Status 'pending'
        Withdrawal::create([
            'user_id' => $user->id,
            'amount_points' => $request->amount_points,
            'payment_method' => $request->payment_method,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permintaan penarikan berhasil dikirim! Mohon tunggu konfirmasi transfer dari Admin.');
    }
}