<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewPlaceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewPlaceUserController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id'    => 'required|integer',
        'user_name'  => 'required|string|max:255',
        'user_email' => 'required|email|max:255',
        'place_name' => 'required|string|max:255',
        'google_map_link' => 'required|url',
        'province' => 'required|string|max:50',
        'district' => 'required|string|max:60',
        'location' => 'required|string|max:255',
        'nearest_city' => 'required|string|max:255',
        'description' => 'required|string',
        'best_suited_for' => 'required|string|max:255',
        'activities_offered' => 'required|string',
        'rating' => 'required|integer|between:1,5',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('place_images', 'public');
    }

    $newPlace = NewPlaceUser::create($validated);

    return response()->json([
        'message' => 'New place submitted successfully',
        'id' => $newPlace->id
    ], 201);
}

}
