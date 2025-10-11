<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedBooking extends Model
{
    protected $table = 'fixed_bookings';
    
    // Specify the connection to use for the user database
    protected $connection = 'mysql';
    
    protected $fillable = [
        'user_id',
        'package_id',
        'package_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'pickup_location',
        'payment_method',
        'receipt',
        'participants',
        'total_price',
        'status'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'participants' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        // Assuming there's a packages table in the user database
        // You might need to adjust this based on your actual package model
        return $this->belongsTo(Package::class, 'package_id');
    }
}