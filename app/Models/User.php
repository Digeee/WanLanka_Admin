<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'dob', 'address', 'city', 'district', 'province', 'country',
        'phone', 'emergency_name', 'emergency_phone', 'id_type', 'id_number', 'id_image',
        'profile_photo', 'preferred_language', 'marketing_opt_in', 'accept_terms', 'is_verified',
        'otp', 'otp_attempts', 'otp_expires_at', 'email_verified_at', 'remember_token',
    ];

    protected $casts = [
        'marketing_opt_in' => 'boolean',
        'accept_terms' => 'boolean',
        'is_verified' => 'boolean',
        'otp_expires_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    protected $hidden = [
        'password', 'remember_token', 'otp', 'otp_attempts', 'otp_expires_at',
    ];
}
