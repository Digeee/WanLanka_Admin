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
        'status',
    ];

    protected $casts = [
        'languages' => 'array',
        'specializations' => 'array',
        'availability' => 'boolean',
    ];
}
