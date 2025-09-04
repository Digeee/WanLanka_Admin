<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'location',
        'province',
        'district',
        'description',
        'weather',
        'travel_type',
        'season',
        'slug',
        'latitude',
        'longitude',
        'gallery',
        'entry_fee',
        'opening_hours',
        'best_time_to_visit',
        'rating',
        'status',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];
}
