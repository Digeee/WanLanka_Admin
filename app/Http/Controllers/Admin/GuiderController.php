<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guider;
use Illuminate\Http\Request;

class GuiderController extends Controller
{
public function index()
{
    $guiders = \App\Models\Guider::paginate(10);
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
            'last_name'  => 'required|string',
            'email'      => 'required|email|unique:guiders',
            'phone'      => 'nullable|string',
            'address'    => 'nullable|string',
            'city'       => 'nullable|string',
            'languages'  => 'nullable|array',
            'specializations' => 'nullable|array',
            'experience_years' => 'integer|min:0',
            'hourly_rate' => 'numeric|min:0',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'status' => 'in:active,inactive',
        ]);

        // handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('guiders', 'public');
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
            'last_name'  => 'required|string',
            'email'      => 'required|email|unique:guiders,email,' . $guider->id,
            'phone'      => 'nullable|string',
            'address'    => 'nullable|string',
            'city'       => 'nullable|string',
            'languages'  => 'nullable|array',
            'specializations' => 'nullable|array',
            'experience_years' => 'integer|min:0',
            'hourly_rate' => 'numeric|min:0',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'status' => 'in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('guiders', 'public');
        }

        $guider->update($data);

        return redirect()->route('admin.guiders.index')->with('success', 'Guider updated successfully.');
    }

    public function destroy(Guider $guider)
    {
        $guider->delete();
        return redirect()->route('admin.guiders.index')->with('success', 'Guider deleted successfully.');
    }

    public function show(Guider $guider)
    {
        return view('admin.guiders.show', compact('guider'));
    }
}
