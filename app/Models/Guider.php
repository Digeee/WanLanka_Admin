<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guider extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'languages',
        'specializations',
        'experience_years',
        'hourly_rate',
        'availability',
        'description',
        'image',
        'nic_number',
        'driving_license_photo',
        'vehicle_types',
        'status',
    ];

    protected $casts = [
        'languages' => 'array',
        'specializations' => 'array',
        'vehicle_types' => 'array',
        'availability' => 'boolean',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'guider_id');
    }
}
