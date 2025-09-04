<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AccommodationController extends Controller
{
    private $provinceDistricts = [
        'Northern' => ['Jaffna', 'Kilinochchi', 'Mannar', 'Mullaitivu', 'Vavuniya'],
        'North Western' => ['Puttalam', 'Kurunegala'],
        'Western' => ['Gampaha', 'Colombo', 'Kalutara'],
        'North Central' => ['Anuradhapura', 'Polonnaruwa'],
        'Central' => ['Matale', 'Kandy', 'Nuwara Eliya'],
        'Sabaragamuwa' => ['Kegalle', 'Ratnapura'],
        'Eastern' => ['Trincomalee', 'Batticaloa', 'Ampara'],
        'Uva' => ['Badulla', 'Monaragala'],
        'Southern' => ['Hambantota', 'Matara', 'Galle']
    ];

    public function index()
    {
        $accommodations = Accommodation::paginate(10);
        return view('admin.accommodations.index', compact('accommodations'));
    }

    public function create()
    {
        return view('admin.accommodations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'province' => ['required', Rule::in(array_keys($this->provinceDistricts))],
            'district' => ['required', function ($attribute, $value, $fail) use ($request) {
                $province = $request->input('province');
                if ($province && !in_array($value, $this->provinceDistricts[$province] ?? [])) {
                    $fail('The selected district is not valid for the chosen province.');
                }
            }],
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price_per_night' => 'required|numeric|min:0',
            'room_types' => 'nullable|array',
            'amenities' => 'nullable|array',
            'rating' => 'nullable|numeric|between:0,5',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:9048',
            'reviews' => 'nullable|array',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('accommodations', 'public');
        }

        // Convert comma-separated inputs to arrays
        if ($request->has('room_types')) {
            $data['room_types'] = explode(',', $request->input('room_types')[0]);
        }
        if ($request->has('amenities')) {
            $data['amenities'] = explode(',', $request->input('amenities')[0]);
        }
        if ($request->has('reviews')) {
            $data['reviews'] = explode(',', $request->input('reviews')[0]);
        }

        Accommodation::create($data);
        return redirect()->route('admin.accommodations.index')->with('success', 'Accommodation added successfully.');
    }

    public function show(Accommodation $accommodation)
    {
        return view('admin.accommodations.show', compact('accommodation'));
    }

    public function edit(Accommodation $accommodation)
    {
        return view('admin.accommodations.edit', compact('accommodation'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'province' => ['required', Rule::in(array_keys($this->provinceDistricts))],
            'district' => ['required', function ($attribute, $value, $fail) use ($request) {
                $province = $request->input('province');
                if ($province && !in_array($value, $this->provinceDistricts[$province] ?? [])) {
                    $fail('The selected district is not valid for the chosen province.');
                }
            }],
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price_per_night' => 'required|numeric|min:0',
            'room_types' => 'nullable|array',
            'amenities' => 'nullable|array',
            'rating' => 'nullable|numeric|between:0,5',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:9048',
            'reviews' => 'nullable|array',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($accommodation->image && Storage::disk('public')->exists($accommodation->image)) {
                Storage::disk('public')->delete($accommodation->image);
            }
            $data['image'] = $request->file('image')->store('accommodations', 'public');
        }

        // Convert comma-separated inputs to arrays
        if ($request->has('room_types')) {
            $data['room_types'] = explode(',', $request->input('room_types')[0]);
        }
        if ($request->has('amenities')) {
            $data['amenities'] = explode(',', $request->input('amenities')[0]);
        }
        if ($request->has('reviews')) {
            $data['reviews'] = explode(',', $request->input('reviews')[0]);
        }

        $accommodation->update($data);
        return redirect()->route('admin.accommodations.index')->with('success', 'Accommodation updated successfully.');
    }

    public function destroy(Accommodation $accommodation)
    {
        if ($accommodation->image && Storage::disk('public')->exists($accommodation->image)) {
            Storage::disk('public')->delete($accommodation->image);
        }
        $accommodation->delete();
        return redirect()->route('admin.accommodations.index')->with('success', 'Accommodation deleted successfully.');
    }
}
