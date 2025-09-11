<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'API is working']);
    }


    public function index(Request $request)
    {
        $query = Package::select('id', 'package_name', 'cover_image', 'description', 'price')
                       ->where('status', 'active');

        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->has('min_rating') && is_numeric($request->min_rating)) {
            $query->where('rating', '>=', $request->min_rating);
        }
        if ($request->has('days') && is_numeric($request->days)) {
            $query->where('days', $request->days);
        }

        $packages = $query->get();
        return response()->json($packages->map(function ($package) {
            $package->cover_image = $package->cover_image ? asset('storage/' . $package->cover_image) : null;
            $package->price = number_format($package->price, 2);
            return $package;
        }));
    }

    public function show($id)
{
    $package = Package::with('relatedPlaces', 'accommodations', 'dayPlans.accommodation', 'vehicle')
                      ->findOrFail($id);

    $package->cover_image = $package->cover_image ? asset('storage/' . $package->cover_image) : null;
    $package->gallery = $package->gallery ? array_map(fn($path) => asset('storage/' . $path), $package->gallery) : [];
    $package->price = number_format($package->price, 2);
    $package->starting_date = $package->starting_date ? date('Y-m-d', strtotime($package->starting_date)) : 'N/A';
    $package->expiry_date = $package->expiry_date ? date('Y-m-d', strtotime($package->expiry_date)) : 'N/A';
    $package->inclusions = $package->inclusions ? implode(', ', $package->inclusions) : 'N/A';
    $package->reviews = $package->reviews ? implode(', ', $package->reviews) : 'N/A';
    $package->rating = $package->rating ? $package->rating . ' Stars' : 'N/A';

    foreach ($package->dayPlans as $dayPlan) {
        $dayPlan->photos = $dayPlan->photos ? array_map(fn($path) => asset('storage/' . $path), $dayPlan->photos) : [];
    }

    return response()->json($package);
}
}
