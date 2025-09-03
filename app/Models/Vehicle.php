<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'number_plate',
        'photo',
        'seat_count',
        'model',
        'year',
        'color',
        'description',
        'status',
    ];

    protected $casts = [
        'seat_count' => 'integer',
    ];
}
