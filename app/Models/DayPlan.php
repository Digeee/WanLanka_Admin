<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayPlan extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'day_number', 'plan', 'accommodation_id', 'description', 'photos'];

    protected $casts = [
        'photos' => 'array',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }
}
