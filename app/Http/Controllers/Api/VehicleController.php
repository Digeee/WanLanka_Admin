<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::select('id', 'vehicle_type', 'seat_count', 'number_plate')
                          ->where('status', 'active')
                          ->get()
                          ->map(function ($vehicle) {
                              // Add default price since base_price column doesn't exist
                              $vehicle->base_price = number_format($this->getDefaultPrice($vehicle->vehicle_type), 2);
                              return [
                                  'id' => $vehicle->id,
                                  'type' => $vehicle->vehicle_type,
                                  'base_price' => $vehicle->base_price,
                                  'seat_count' => $vehicle->seat_count,
                                  'number_plate' => $vehicle->number_plate,
                              ];
                          });

        return response()->json($vehicles);
    }

    private function getDefaultPrice($vehicleType)
    {
        $prices = [
            'bike' => 2000.00,
            'three_wheeler' => 2500.00,
            'car' => 3000.00,
            'van' => 5000.00,
            'bus' => 10000.00,
        ];

        return $prices[$vehicleType] ?? 3000.00;
    }
}
