<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str; // <-- WAJIB DITAMBAHKAN

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:b2c_user,b2b_user'],
            // Validasi referal: boleh kosong, tapi jika diisi HARUS ada di tabel users
            'referral_input' => ['nullable', 'string', 'exists:users,referral_code'], 
        ], [
            'referral_input.exists' => 'Kode referal tidak ditemukan atau tidak valid.',
        ]);

        // 2. Cari siapa pemilik kode referal tersebut (jika ada)
        $referrer = null;
        if ($request->referral_input) {
            $referrer = User::where('referral_code', $request->referral_input)->first();
        }

        // 3. Simpan User Baru & Buatkan Kode Unik untuknya
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'referral_code' => strtoupper(Str::random(8)), // Menghasilkan kode acak 8 karakter (ex: A8F9K2P1)
            'referred_by' => $referrer ? $referrer->id : null,
        ]);

        // 4. BERIKAN BONUS POIN KE PEMILIK KODE LAMA
        if ($referrer) {
            // Berikan bonus (misal: 5000 poin). Kamu bisa menyesuaikan angkanya.
            $referrer->increment('point_balance', 5000); 
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}