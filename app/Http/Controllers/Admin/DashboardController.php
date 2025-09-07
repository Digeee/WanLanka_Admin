<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guider;
use App\Models\Vehicle;
use App\Models\Accommodation;
use App\Models\Place;
use App\Models\Package;

class DashboardController extends Controller
{
    public function index()
    {
        $guiderCount = Guider::count();
        $vehicleCount = Vehicle::count();
        $accommodationCount = Accommodation::count();
        $placeCount = Place::count();
        $packageCount = Package::count();

        return view('admin.dashboard', compact('guiderCount', 'vehicleCount', 'accommodationCount', 'placeCount', 'packageCount'));
    }
}
