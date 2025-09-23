<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'place_id', 'pickup_district', 'pickup_location', 'people_count',
        'date', 'time', 'vehicle_id', 'total_price', 'guider', 'status'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
