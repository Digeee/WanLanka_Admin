<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewPlaceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserSentPlaceController extends Controller
{
    public function index()
    {
        $places = NewPlaceUser::latest()->get();
        return view('admin.places.user-sent-places', compact('places'));
    }

    public function show($id)
    {
        $place = NewPlaceUser::findOrFail($id);
        return view('admin.places.show-user-sent', compact('place'));
    }

    public function edit($id)
    {
        $place = NewPlaceUser::findOrFail($id);
        return view('admin.places.edit-user-sent', compact('place'));
    }

    public function update(Request $request, $id)
    {
        $place = NewPlaceUser::findOrFail($id);

        $validated = $request->validate([
            'place_name'        => 'required|string|max:255',
            'google_map_link'   => 'required|url',
            'province'          => 'required|string|max:50',
            'district'          => 'required|string|max:60',
            'location'          => 'required|string|max:255',
            'nearest_city'      => 'required|string|max:255',
            'description'       => 'required|string',
            'best_suited_for'   => 'required|string|max:255',
            'activities_offered'=> 'required|string',
            'rating'            => 'required|integer|between:1,5',
            'status'            => 'required|in:pending,approved,rejected',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        // Handle image replacement
        if ($request->hasFile('image')) {
            if ($place->image) {
                Storage::disk('public')->delete($place->image);
            }
            $validated['image'] = $request->file('image')->store('place_images', 'public');
        }

        $place->update($validated);

        return redirect()->route('admin.places.user-sent.index')
            ->with('success', 'User-submitted place updated successfully.');
    }

    public function destroy($id)
    {
        $place = NewPlaceUser::findOrFail($id);

        if ($place->image) {
            Storage::disk('public')->delete($place->image);
        }

        $place->delete();

        return redirect()->route('admin.places.user-sent.index')
            ->with('success', 'User-submitted place deleted successfully.');
    }
}
