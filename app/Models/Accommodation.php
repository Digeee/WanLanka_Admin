<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'province',
        'district',
        'location',
        'latitude',
        'longitude',
        'price_per_night',
        'room_types',
        'amenities',
        'rating',
        'image',
        'reviews',
    ];

    protected $casts = [
        'room_types' => 'array',
        'amenities' => 'array',
        'reviews' => 'array',
    ];
}
