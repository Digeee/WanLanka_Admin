<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guider;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $guiderCount = Guider::count();
        $vehicleCount = Vehicle::count();

        return view('admin.dashboard', compact('guiderCount', 'vehicleCount'));
    }
}
