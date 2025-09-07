<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Place;
use App\Models\Vehicle;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $places = Place::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();
        $accommodations = Accommodation::all();
        return view('admin.packages.create', compact('places', 'vehicles', 'accommodations'));
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,png,jpeg|max:2048',
            'starting_date' => 'nullable|date|after_or_equal:today',
            'expiry_date' => 'nullable|date|after:starting_date',
            'related_places' => 'required|array',
            'related_places.*' => 'exists:places,id',
            'accommodations' => 'required|array',
            'accommodations.*' => 'exists:accommodations,id',
            'days' => 'required|integer|min:1',
            'day_plans' => 'nullable|array',
            'day_plans.*.plan' => 'nullable|string',
            'day_plans.*.accommodation_id' => 'nullable|exists:accommodations,id',
            'day_plans.*.description' => 'nullable|string',
            'day_plans.*.photos' => 'nullable|array',
            'day_plans.*.photos.*' => 'image|mimes:jpg,png,jpeg|max:2048',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'string|max:255',
            'vehicle_type_id' => 'required|exists:vehicles,id',
            'package_type' => 'required|in:low_budget,high_budget,custom',
            'status' => 'required|in:active,inactive,draft',
            'rating' => 'nullable|numeric|between:0,5',
            'reviews' => 'nullable|array',
            'reviews.*' => 'string',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($data['package_name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Package::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        // Store related places in JSON column for backward compatibility
        $data['places'] = $request->input('related_places', []);

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('packages', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('packages/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Handle day plans photos
        if ($request->has('day_plans')) {
            foreach ($data['day_plans'] as $day => &$plan) {
                if ($request->hasFile("day_plans.{$day}.photos")) {
                    $photos = [];
                    foreach ($request->file("day_plans.{$day}.photos") as $photo) {
                        $photos[] = $photo->store('packages/day_plans', 'public');
                    }
                    $plan['photos'] = $photos;
                }
            }
        }

        // Create package
        $package = Package::create($data);

        // Sync places and accommodations
        $package->relatedPlaces()->sync($request->input('related_places', []));
        $package->accommodations()->sync($request->input('accommodations', []));

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified package.
     */
    public function show(Package $package)
    {
        $package->load('relatedPlaces', 'vehicle', 'accommodations');
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package)
    {
        $package->load('relatedPlaces', 'accommodations');
        $places = Place::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();
        $accommodations = Accommodation::all();
        return view('admin.packages.edit', compact('package', 'places', 'vehicles', 'accommodations'));
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,png,jpeg|max:2048',
            'starting_date' => 'nullable|date|after_or_equal:today',
            'expiry_date' => 'nullable|date|after:starting_date',
            'related_places' => 'required|array',
            'related_places.*' => 'exists:places,id',
            'accommodations' => 'required|array',
            'accommodations.*' => 'exists:accommodations,id',
            'days' => 'required|integer|min:1',
            'day_plans' => 'nullable|array',
            'day_plans.*.plan' => 'nullable|string',
            'day_plans.*.accommodation_id' => 'nullable|exists:accommodations,id',
            'day_plans.*.description' => 'nullable|string',
            'day_plans.*.photos' => 'nullable|array',
            'day_plans.*.photos.*' => 'image|mimes:jpg,png,jpeg|max:2048',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'string|max:255',
            'vehicle_type_id' => 'required|exists:vehicles,id',
            'package_type' => 'required|in:low_budget,high_budget,custom',
            'status' => 'required|in:active,inactive,draft',
            'rating' => 'nullable|numeric|between:0,5',
            'reviews' => 'nullable|array',
            'reviews.*' => 'string',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($data['package_name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Package::where('slug', $slug)->where('id', '!=', $package->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;

        // Store related places in JSON column for backward compatibility
        $data['places'] = $request->input('related_places', []);

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            if ($package->cover_image && Storage::disk('public')->exists($package->cover_image)) {
                Storage::disk('public')->delete($package->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('packages', 'public');
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            if ($package->gallery) {
                foreach ($package->gallery as $existingImage) {
                    Storage::disk('public')->delete($existingImage);
                }
            }
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('packages/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Handle day plans photos
        if ($request->has('day_plans')) {
            foreach ($package->day_plans ?? [] as $day => $existingPlan) {
                if (!empty($existingPlan['photos'])) {
                    foreach ($existingPlan['photos'] as $photo) {
                        Storage::disk('public')->delete($photo);
                    }
                }
            }
            foreach ($data['day_plans'] as $day => &$plan) {
                if ($request->hasFile("day_plans.{$day}.photos")) {
                    $photos = [];
                    foreach ($request->file("day_plans.{$day}.photos") as $photo) {
                        $photos[] = $photo->store('packages/day_plans', 'public');
                    }
                    $plan['photos'] = $photos;
                }
            }
        }

        // Update package
        $package->update($data);

        // Sync places and accommodations
        $package->relatedPlaces()->sync($request->input('related_places', []));
        $package->accommodations()->sync($request->input('accommodations', []));

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy(Package $package)
    {
        // Delete cover image
        if ($package->cover_image && Storage::disk('public')->exists($package->cover_image)) {
            Storage::disk('public')->delete($package->cover_image);
        }

        // Delete gallery images
        if ($package->gallery) {
            foreach ($package->gallery as $galleryImage) {
                Storage::disk('public')->delete($galleryImage);
            }
        }

        // Delete day plan photos
        if ($package->day_plans) {
            foreach ($package->day_plans as $dayPlan) {
                if (!empty($dayPlan['photos'])) {
                    foreach ($dayPlan['photos'] as $photo) {
                        Storage::disk('public')->delete($photo);
                    }
                }
            }
        }

        // Detach relationships
        $package->relatedPlaces()->detach();
        $package->accommodations()->detach();

        // Delete package
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
