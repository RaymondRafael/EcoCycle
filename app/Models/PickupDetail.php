<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupDetail extends Model
{
    protected $fillable = ['pickup_id', 'waste_category_id', 'weight_kg', 'subtotal_points'];

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }

    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class, 'waste_category_id');
    }
}
