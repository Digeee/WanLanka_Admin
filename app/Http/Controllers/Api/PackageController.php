<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'API is working']);
    }

    public function index()
    {
        $packages = Package::select('id', 'package_name', 'cover_image', 'description')
                          ->where('status', 'active')
                          ->get();
        return response()->json($packages->map(function ($package) {
            $package->cover_image = $package->cover_image ? asset('storage/' . $package->cover_image) : null;
            return $package;
        }));
    }

    public function show($id)
    {
        $package = Package::select('id', 'package_name', 'cover_image', 'description')
                         ->where('status', 'active')
                         ->findOrFail($id);
        $package->cover_image = $package->cover_image ? asset('storage/' . $package->cover_image) : null;
        return response()->json($package);
    }
}
