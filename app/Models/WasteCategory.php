<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    protected $fillable = ['name', 'point_reward_per_kg', 'price_to_factory_per_kg'];
}
