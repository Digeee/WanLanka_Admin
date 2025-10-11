<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPackage;
use App\Models\User;
use App\Models\Guider;
use App\Mail\CustomPackageAssignmentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class CustomPackageController extends Controller
{
    /**
     * Display a listing of custom packages.
     */
    public function index()
    {
        $packages = CustomPackage::paginate(10);
        return view('admin.bookings.custom booking.index', compact('packages'));
    }

    /**
     * Show the form for creating a new custom package.
     */
    public function create()
    {
        $users = User::all();
        $guiders = Guider::all();
        return view('admin.bookings.custom booking.create', compact('users', 'guiders'));
    }

    /**
     * Store a newly created custom package in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'guider_id' => 'nullable|exists:guiders,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'num_people' => 'required|integer|min:1',
            'travel_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'destinations' => 'required|array',
            'destinations.*' => 'string|max:255',
            'vehicles' => 'required|array',
            'vehicles.*' => 'string|max:255',
            'accommodations' => 'required|array',
            'accommodations.*' => 'string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'status' => 'required|in:pending,approved,rejected,active,inactive',
        ]);

        // Convert arrays to JSON
        $validated['destinations'] = json_encode(array_values(array_filter($validated['destinations'])));
        $validated['vehicles'] = json_encode(array_values(array_filter($validated['vehicles'])));
        $validated['accommodations'] = json_encode(array_values(array_filter($validated['accommodations'])));

        // Set guider name and email if guider is selected
        if (!empty($validated['guider_id'])) {
            $guider = Guider::find($validated['guider_id']);
            $validated['guider_name'] = $guider->first_name . ' ' . $guider->last_name;
            $validated['guider_email'] = $guider->email;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('custom_packages', 'public');
            $validated['image'] = $path;
        }

        $package = CustomPackage::create($validated);

        return redirect()->route('admin.custom-packages.index')->with('success', 'Custom package created successfully.');
    }

    /**
     * Display the specified custom package.
     */
    public function show(CustomPackage $customPackage)
    {
        return view('admin.bookings.custom booking.show', compact('customPackage'));
    }

    /**
     * Show the form for editing the specified custom package.
     */
    public function edit(CustomPackage $customPackage)
    {
        $users = User::all();
        $guiders = Guider::all();
        // Decode JSON fields for editing
        $customPackage->destinations = json_decode($customPackage->destinations, true);
        $customPackage->vehicles = json_decode($customPackage->vehicles, true);
        $customPackage->accommodations = json_decode($customPackage->accommodations, true);
        
        return view('admin.bookings.custom booking.edit', compact('customPackage', 'users', 'guiders'));
    }

    /**
     * Update the specified custom package in storage.
     */
    public function update(Request $request, CustomPackage $customPackage)
    {
        // Clean up empty array values before validation
        $cleanedInput = $request->all();
        if (isset($cleanedInput['destinations'])) {
            $cleanedInput['destinations'] = array_filter($cleanedInput['destinations'], function($value) {
                return !empty(trim($value));
            });
            $cleanedInput['destinations'] = array_values($cleanedInput['destinations']);
        }
        if (isset($cleanedInput['vehicles'])) {
            $cleanedInput['vehicles'] = array_filter($cleanedInput['vehicles'], function($value) {
                return !empty(trim($value));
            });
            $cleanedInput['vehicles'] = array_values($cleanedInput['vehicles']);
        }
        if (isset($cleanedInput['accommodations'])) {
            $cleanedInput['accommodations'] = array_filter($cleanedInput['accommodations'], function($value) {
                return !empty(trim($value));
            });
            $cleanedInput['accommodations'] = array_values($cleanedInput['accommodations']);
        }
        
        $request->merge($cleanedInput);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'guider_id' => 'nullable|exists:guiders,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'num_people' => 'required|integer|min:1',
            'travel_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'destinations' => 'required|array|min:1',
            'destinations.*' => 'required|string|max:255',
            'vehicles' => 'required|array|min:1',
            'vehicles.*' => 'required|string|max:255',
            'accommodations' => 'required|array|min:1',
            'accommodations.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:9048',
            'status' => 'required|in:pending,approved,rejected,active,inactive',
        ]);

        // Include all validated fields in the update data
        $updateData = [
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_location' => $validated['start_location'],
            'duration' => $validated['duration'],
            'num_people' => $validated['num_people'],
            'travel_date' => $validated['travel_date'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ];

        // Filter out empty values and convert arrays to JSON
        $destinations = array_filter($request->destinations, function($value) {
            return !empty(trim($value));
        });
        $vehicles = array_filter($request->vehicles, function($value) {
            return !empty(trim($value));
        });
        $accommodations = array_filter($request->accommodations, function($value) {
            return !empty(trim($value));
        });

        // Ensure we always have valid JSON arrays, even if empty
        $updateData['destinations'] = json_encode(array_values($destinations ?: []));
        $updateData['vehicles'] = json_encode(array_values($vehicles ?: []));
        $updateData['accommodations'] = json_encode(array_values($accommodations ?: []));

        // Set guider name and email if guider is selected
        if (!empty($validated['guider_id'])) {
            $guider = Guider::find($validated['guider_id']);
            $updateData['guider_id'] = $validated['guider_id'];
            $updateData['guider_name'] = $guider->first_name . ' ' . $guider->last_name;
            $updateData['guider_email'] = $guider->email;
        } else {
            $updateData['guider_id'] = null;
            $updateData['guider_name'] = null;
            $updateData['guider_email'] = null;
        }

        if ($request->hasFile('image')) {
            if ($customPackage->image) {
                Storage::disk('public')->delete($customPackage->image);
            }
            $path = $request->file('image')->store('custom_packages', 'public');
            $updateData['image'] = $path;
        }

        // Get old values for comparison
        $oldGuiderId = $customPackage->guider_id;
        $oldStatus = $customPackage->status;

        $customPackage->update($updateData);

        // Send email notifications
        $this->sendAssignmentEmails($customPackage, $oldGuiderId, $oldStatus);

        return redirect()->route('admin.custom-packages.index')->with('success', 'Custom package updated successfully.');
    }

    /**
     * Send assignment emails to user and guider
     */
    private function sendAssignmentEmails($customPackage, $oldGuiderId, $oldStatus)
    {
        $user = $customPackage->user;
        $guider = $customPackage->guider;

        // Send email to user
        if ($user && $user->email) {
            Mail::to($user->email)->send(new CustomPackageAssignmentMail($customPackage, $user, $guider, 'user'));
        }

        // Send email to guider if assigned
        if ($guider && $guider->email) {
            Mail::to($guider->email)->send(new CustomPackageAssignmentMail($customPackage, $user, $guider, 'guider'));
        }
    }

    /**
     * Remove the specified custom package from storage.
     */
    public function destroy(CustomPackage $customPackage)
    {
        if ($customPackage->image) {
            Storage::disk('public')->delete($customPackage->image);
        }

        $customPackage->delete();

        return redirect()->route('admin.custom-packages.index')->with('success', 'Custom package deleted successfully.');
    }
}