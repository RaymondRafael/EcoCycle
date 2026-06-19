<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'user_id',
        'driver_id',
        'pickup_date',
        'pickup_address',
        'status',
        'total_points_earned',
    ];

    // Memastikan pickup_date otomatis dibaca sebagai objek Carbon (waktu)
    protected $casts = [
        'pickup_date' => 'datetime',
    ];

    // Relasi ke User (Pemilik Sampah)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Driver (Mitra Penjemput)
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}