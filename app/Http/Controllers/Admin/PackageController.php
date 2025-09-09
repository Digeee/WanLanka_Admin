<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Place;
use App\Models\Accommodation;
use App\Models\Vehicle;
use App\Models\DayPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index()
    {
        $packages = Package::paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create()
    {
        $places = Place::all();
        $accommodations = Accommodation::all();
        $vehicles = Vehicle::all();
        return view('admin.packages.create', compact('places', 'accommodations', 'vehicles'));
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'starting_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:starting_date',
            'related_places' => 'required|array',
            'related_places.*' => 'exists:places,id',
            'accommodations' => 'required|array',
            'accommodations.*' => 'exists:accommodations,id',
            'days' => 'required|integer|min:1',
            'day_plans' => 'nullable|array',
            'day_plans.*.plan' => 'nullable|string',
            'day_plans.*.accommodation_id' => 'nullable|exists:accommodations,id',
            'day_plans.*.description' => 'nullable|string',
            'day_plans.*.photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'inclusions' => 'nullable|array',
            'vehicle_type_id' => 'required|exists:vehicles,id',
            'package_type' => 'required|in:low_budget,high_budget,custom',
            'status' => 'required|in:active,inactive,draft',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|array',
        ]);

        Log::info('Validated data: ' . json_encode($validated));

        $data = $validated;
        $data['slug'] = Str::slug($validated['package_name']);
        if ($request->hasFile('cover_image')) {
            Log::info('Cover image uploaded: ' . $request->file('cover_image')->getClientOriginalName());
            $path = $request->file('cover_image')->store('packages', 'public');
            Log::info('Cover image stored at: ' . $path);
            $data['cover_image'] = $path;
        } else {
            Log::info('No cover image uploaded');
            $data['cover_image'] = null;
        }

        $package = Package::create($data);

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('gallery', 'public');
            }
            $package->gallery = $galleryPaths;
            $package->save();
        }

        if (!empty($validated['day_plans'])) {
            foreach ($validated['day_plans'] as $index => $dayPlan) {
                $photos = [];
                if ($request->hasFile("day_plans.$index.photos")) {
                    foreach ($request->file("day_plans.$index.photos") as $photo) {
                        $photos[] = $photo->store('day_plans', 'public');
                    }
                }
                $package->dayPlans()->create([
                    'day_number' => $index + 1,
                    'plan' => $dayPlan['plan'] ?? null,
                    'accommodation_id' => $dayPlan['accommodation_id'] ?? null,
                    'description' => $dayPlan['description'] ?? null,
                    'photos' => $photos,
                ]);
            }
        }

        $package->relatedPlaces()->sync($validated['related_places']);
        $package->accommodations()->sync($validated['accommodations']);
        $package->inclusions = $validated['inclusions'] ?? [];
        $package->reviews = $validated['reviews'] ?? [];
        $package->save();

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified package.
     */
    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package)
    {
        $places = Place::all();
        $accommodations = Accommodation::all();
        $vehicles = Vehicle::all();
        return view('admin.packages.edit', compact('package', 'places', 'accommodations', 'vehicles'));
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'starting_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:starting_date',
            'related_places' => 'required|array',
            'related_places.*' => 'exists:places,id',
            'accommodations' => 'required|array',
            'accommodations.*' => 'exists:accommodations,id',
            'days' => 'required|integer|min:1',
            'day_plans' => 'nullable|array',
            'day_plans.*.plan' => 'nullable|string',
            'day_plans.*.accommodation_id' => 'nullable|exists:accommodations,id',
            'day_plans.*.description' => 'nullable|string',
            'day_plans.*.photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'inclusions' => 'nullable|array',
            'vehicle_type_id' => 'required|exists:vehicles,id',
            'package_type' => 'required|in:low_budget,high_budget,custom',
            'status' => 'required|in:active,inactive,draft',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|array',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['package_name']);
        if ($request->hasFile('cover_image')) {
            if ($package->cover_image) {
                Storage::disk('public')->delete($package->cover_image);
            }
            $path = $request->file('cover_image')->store('packages', 'public');
            $data['cover_image'] = $path;
        }

        $package->update($data);

        if ($request->hasFile('gallery')) {
            $galleryPaths = $package->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('gallery', 'public');
            }
            $package->gallery = $galleryPaths;
            $package->save();
        }

        $package->dayPlans()->delete();
        if (!empty($validated['day_plans'])) {
            foreach ($validated['day_plans'] as $index => $dayPlan) {
                $photos = [];
                if ($request->hasFile("day_plans.$index.photos")) {
                    foreach ($request->file("day_plans.$index.photos") as $photo) {
                        $photos[] = $photo->store('day_plans', 'public');
                    }
                }
                $package->dayPlans()->create([
                    'day_number' => $index + 1,
                    'plan' => $dayPlan['plan'] ?? null,
                    'accommodation_id' => $dayPlan['accommodation_id'] ?? null,
                    'description' => $dayPlan['description'] ?? null,
                    'photos' => $photos,
                ]);
            }
        }

        $package->relatedPlaces()->sync($validated['related_places']);
        $package->accommodations()->sync($validated['accommodations']);
        $package->inclusions = $validated['inclusions'] ?? [];
        $package->reviews = $validated['reviews'] ?? [];
        $package->save();

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy(Package $package)
    {
        if ($package->cover_image) {
            Storage::disk('public')->delete($package->cover_image);
        }
        if ($package->gallery && is_array($package->gallery)) {
            foreach ($package->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        if ($package->dayPlans()->exists()) {
            foreach ($package->dayPlans as $dayPlan) {
                if ($dayPlan->photos && is_array($dayPlan->photos)) {
                    foreach ($dayPlan->photos as $photo) {
                        Storage::disk('public')->delete($photo);
                    }
                }
            }
            $package->dayPlans()->delete();
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
