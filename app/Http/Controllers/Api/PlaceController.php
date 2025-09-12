<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlaceController extends Controller
{
    public function provinces()
    {
        $provinces = Place::where('status', 'active')
                          ->select('province')
                          ->distinct()
                          ->orderBy('province')
                          ->get()
                          ->map(function ($place) {
                              return [
                                  'name' => $place->province,
                                  'slug' => Str::slug($place->province),
                                  'description' => 'Discover the best places in ' . $place->province . '.',
                                  'image' => Place::where('province', $place->province)->first()->image ? asset('storage/' . Place::where('province', $place->province)->first()->image) : null,
                                  'count' => Place::where('province', $place->province)->count()
                              ];
                          });

        return response()->json($provinces);
    }

    public function provincePlaces($slug)
    {
        $places = Place::where('status', 'active')
                       ->where('province', $slug)
                       ->get()
                       ->map(function ($place) {
                           return [
                               'id' => $place->id,
                               'name' => $place->name,
                               'image' => $place->image ? asset('storage/' . $place->image) : asset('images/default-place.jpg'),
                               'district' => $place->district,
                               'description' => Str::limit($place->description, 100, '...'),
                               'slug' => $place->slug,
                               'rating' => $place->rating ?? 'N/A'
                           ];
                       });

        return response()->json($places);
    }

    public function show($slug)
    {
        $place = Place::where('slug', $slug)
                      ->where('status', 'active')
                      ->firstOrFail();

        $place->image = $place->image ? asset('storage/' . $place->image) : null;
        $place->gallery = is_array($place->gallery) ? array_map(fn($path) => asset('storage/' . $path), $place->gallery) : [];
        $place->entry_fee = number_format($place->entry_fee, 2);

        return response()->json($place);
    }
}
