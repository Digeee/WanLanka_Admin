<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_type' => 'required|in:bike,three_wheeler,car,van,bus',
            'number_plate' => 'required|string|unique:vehicles',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:9048',
            'seat_count' => 'required|integer|min:1',
            'model' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'color' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle added successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'vehicle_type' => 'required|in:bike,three_wheeler,car,van,bus',
            'number_plate' => 'required|string|unique:vehicles,number_plate,' . $vehicle->id,
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'seat_count' => 'required|integer|min:1',
            'model' => 'nullable|string',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'color' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($vehicle->photo && Storage::disk('public')->exists($vehicle->photo)) {
                Storage::disk('public')->delete($vehicle->photo);
            }
            $data['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->photo && Storage::disk('public')->exists($vehicle->photo)) {
            Storage::disk('public')->delete($vehicle->photo);
        }
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
