<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'description',
        'price',
        'cover_image',
        'gallery',
        'starting_date',
        'expiry_date',
        'places',
        'days',
        'day_plans',
        'inclusions',
        'vehicle_type_id',
        'package_type',
        'status',
        'rating',
        'reviews',
        'slug',
    ];

    protected $casts = [
        'gallery' => 'array',
        'places' => 'array',
        'day_plans' => 'array',
        'inclusions' => 'array',
        'reviews' => 'array',
        'starting_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_type_id');
    }

    public function relatedPlaces()
    {
        return $this->belongsToMany(Place::class, 'package_place', 'package_id', 'place_id');
    }

    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class, 'package_accommodation', 'package_id', 'accommodation_id');
    }
}
