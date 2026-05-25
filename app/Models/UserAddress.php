<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'label_name', 'pic_name', 'phone', 'city', 'full_address', 'postal_code', 'is_primary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}