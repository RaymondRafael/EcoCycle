<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    // Mengizinkan kolom-kolom ini diisi data (Mass Assignment)
    protected $fillable = [
        'user_id', 
        'amount_points', 
        'payment_method', 
        'account_number', 
        'account_name', 
        'status'
    ];

    // Relasi: Satu penarikan dana dimiliki oleh satu pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}