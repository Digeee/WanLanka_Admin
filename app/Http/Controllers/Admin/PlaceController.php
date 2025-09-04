<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PlaceController extends Controller
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
        $places = Place::paginate(10);
        return view('admin.places.index', compact('places'));
    }

    public function create()
    {
        return view('admin.places.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:9048',
            'location' => 'nullable|string|max:255',
            'province' => ['required', Rule::in(array_keys($this->provinceDistricts))],
            'district' => ['required', function ($attribute, $value, $fail) use ($request) {
                $province = $request->input('province');
                if ($province && !in_array($value, $this->provinceDistricts[$province] ?? [])) {
                    $fail('The selected district is not valid for the chosen province.');
                }
            }],
            'description' => 'nullable|string',
            'weather' => 'nullable|string|max:255',
            'travel_type' => 'nullable|string|max:255',
            'season' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,png,jpeg|max:048',
            'entry_fee' => 'nullable|numeric|min:0',
            'opening_hours' => 'nullable|string|max:255',
            'best_time_to_visit' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|between:0,5',
            'status' => 'required|in:active,inactive',
        ]);

        $data['slug'] = Str::slug($data['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('places', 'public');
        }

        // Handle gallery upload (multiple images)
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('places/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        Place::create($data);
        return redirect()->route('admin.places.index')->with('success', 'Place added successfully.');
    }

    public function show(Place $place)
    {
        return view('admin.places.show', compact('place'));
    }

    public function edit(Place $place)
    {
        return view('admin.places.edit', compact('place'));
    }

    public function update(Request $request, Place $place)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'location' => 'nullable|string|max:255',
            'province' => ['required', Rule::in(array_keys($this->provinceDistricts))],
            'district' => ['required', function ($attribute, $value, $fail) use ($request) {
                $province = $request->input('province');
                if ($province && !in_array($value, $this->provinceDistricts[$province] ?? [])) {
                    $fail('The selected district is not valid for the chosen province.');
                }
            }],
            'description' => 'nullable|string',
            'weather' => 'nullable|string|max:255',
            'travel_type' => 'nullable|string|max:255',
            'season' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,png,jpeg|max:9048',
            'entry_fee' => 'nullable|numeric|min:0',
            'opening_hours' => 'nullable|string|max:255',
            'best_time_to_visit' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|between:0,5',
            'status' => 'required|in:active,inactive',
        ]);

        $data['slug'] = Str::slug($data['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($place->image && Storage::disk('public')->exists($place->image)) {
                Storage::disk('public')->delete($place->image);
            }
            $data['image'] = $request->file('image')->store('places', 'public');
        }

        // Handle gallery upload (multiple images)
        if ($request->hasFile('gallery')) {
            $galleryPaths = $place->gallery ?? [];
            foreach ($place->gallery ?? [] as $existingImage) {
                Storage::disk('public')->delete($existingImage);
            }
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('places/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        $place->update($data);
        return redirect()->route('admin.places.index')->with('success', 'Place updated successfully.');
    }

    public function destroy(Place $place)
    {
        if ($place->image && Storage::disk('public')->exists($place->image)) {
            Storage::disk('public')->delete($place->image);
        }
        if ($place->gallery) {
            foreach ($place->gallery as $galleryImage) {
                if (Storage::disk('public')->exists($galleryImage)) {
                    Storage::disk('public')->delete($galleryImage);
                }
            }
        }
        $place->delete();
        return redirect()->route('admin.places.index')->with('success', 'Place deleted successfully.');
    }
}
