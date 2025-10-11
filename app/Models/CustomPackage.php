<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guider_id',
        'guider_name',
        'guider_email',
        'title',
        'description',
        'start_location',
        'duration',
        'num_people',
        'travel_date',
        'price',
        'destinations',
        'vehicles',
        'accommodations',
        'image',
        'status',
    ];

    protected $casts = [
        'destinations' => 'array',
        'vehicles' => 'array',
        'accommodations' => 'array',
        'travel_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guider()
    {
        return $this->belongsTo(Guider::class);
    }
}