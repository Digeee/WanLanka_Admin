<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewPlaceUser extends Model
{
    use HasFactory;

    protected $table = 'new_place_user';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'place_name',
        'google_map_link',
        'province',
        'district',
        'location',
        'nearest_city',
        'description',
        'best_suited_for',
        'activities_offered',
        'rating',
        'image',
        'status',
    ];
}
