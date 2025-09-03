<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuiderController extends Controller
{
    public function index()
    {
        $guiders = Guider::paginate(10);
        return view('admin.guiders.index', compact('guiders'));
    }

    public function create()
    {
        return view('admin.guiders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:guiders',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'languages' => 'nullable|array',
            'specializations' => 'nullable|array',
            'experience_years' => 'integer|min:0',
            'hourly_rate' => 'numeric|min:0',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'nic_number' => 'nullable|string',
            'driving_license_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'vehicle_types' => 'nullable|array',
            'vehicle_types.*' => 'in:bike,auto,car',
            'status' => 'in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('guiders', 'public');
        }

        // Handle driving license photo upload
        if ($request->hasFile('driving_license_photo')) {
            $data['driving_license_photo'] = $request->file('driving_license_photo')->store('guiders', 'public');
        }

        // Convert comma-separated inputs to arrays
        if ($request->has('languages')) {
            $data['languages'] = explode(',', $request->input('languages')[0]);
        }
        if ($request->has('specializations')) {
            $data['specializations'] = explode(',', $request->input('specializations')[0]);
        }
        if ($request->has('vehicle_types')) {
            $data['vehicle_types'] = $request->input('vehicle_types');
        }

        Guider::create($data);
        return redirect()->route('admin.guiders.index')->with('success', 'Guider added successfully.');
    }

    public function edit(Guider $guider)
    {
        return view('admin.guiders.edit', compact('guider'));
    }

    public function update(Request $request, Guider $guider)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:guiders,email,' . $guider->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'languages' => 'nullable|array',
            'specializations' => 'nullable|array',
            'experience_years' => 'integer|min:0',
            'hourly_rate' => 'numeric|min:0',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'nic_number' => 'nullable|string',
            'driving_license_photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'vehicle_types' => 'nullable|array',
            'vehicle_types.*' => 'in:bike,auto,car',
            'status' => 'in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($guider->image && Storage::disk('public')->exists($guider->image)) {
                Storage::disk('public')->delete($guider->image);
            }
            $data['image'] = $request->file('image')->store('guiders', 'public');
        }

        // Handle driving license photo upload
        if ($request->hasFile('driving_license_photo')) {
            if ($guider->driving_license_photo && Storage::disk('public')->exists($guider->driving_license_photo)) {
                Storage::disk('public')->delete($guider->driving_license_photo);
            }
            $data['driving_license_photo'] = $request->file('driving_license_photo')->store('guiders', 'public');
        }

        // Convert comma-separated inputs to arrays
        if ($request->has('languages')) {
            $data['languages'] = explode(',', $request->input('languages')[0]);
        }
        if ($request->has('specializations')) {
            $data['specializations'] = explode(',', $request->input('specializations')[0]);
        }
        if ($request->has('vehicle_types')) {
            $data['vehicle_types'] = $request->input('vehicle_types');
        }

        $guider->update($data);
        return redirect()->route('admin.guiders.index')->with('success', 'Guider updated successfully.');
    }

    public function destroy(Guider $guider)
    {
        if ($guider->image && Storage::disk('public')->exists($guider->image)) {
            Storage::disk('public')->delete($guider->image);
        }
        if ($guider->driving_license_photo && Storage::disk('public')->exists($guider->driving_license_photo)) {
            Storage::disk('public')->delete($guider->driving_license_photo);
        }
        $guider->delete();
        return redirect()->route('admin.guiders.index')->with('success', 'Guider deleted successfully.');
    }

    public function show(Guider $guider)
    {
        return view('admin.guiders.show', compact('guider'));
    }
}
