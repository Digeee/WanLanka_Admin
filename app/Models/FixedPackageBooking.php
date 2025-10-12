<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedPackageBooking extends Model
{
    use HasFactory;

    protected $table = 'fixed_bookings'; // ✅ correct table name

    protected $fillable = [
        'user_id',
        'package_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'pickup_location',
        'participants',
        'total_price',
        'payment_method',
        'status',
        'receipt'
    ];
}
