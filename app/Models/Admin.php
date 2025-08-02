<?php

// app/Models/Admin.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;  // Use the Authenticatable class
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable  // Make sure Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    // You can also define any other custom methods for the Admin model if needed
}
