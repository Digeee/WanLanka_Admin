<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'district' => $user->district,
                'is_verified' => $user->is_verified ? 'Yes' : 'No',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'profile_photo' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : null,
                'id_image' => $user->id_image ? asset('storage/' . $user->id_image) : null,
            ];
        });
         $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:60',
            'province' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:255',
            'id_type' => 'nullable|in:NIC,Passport,Driving License',
            'id_number' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|in:English,Tamil,Sinhala',
            'marketing_opt_in' => 'boolean',
            'accept_terms' => 'boolean',
            'is_verified' => 'boolean',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'id_image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        if ($request->hasFile('id_image')) {
            $validated['id_image'] = $request->file('id_image')->store('id_images', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:60',
            'province' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:255',
            'id_type' => 'nullable|in:NIC,Passport,Driving License',
            'id_number' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|in:English,Tamil,Sinhala',
            'marketing_opt_in' => 'boolean',
            'accept_terms' => 'boolean',
            'is_verified' => 'boolean',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'id_image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        if ($request->hasFile('id_image')) {
            if ($user->id_image && Storage::disk('public')->exists($user->id_image)) {
                Storage::disk('public')->delete($user->id_image);
            }
            $validated['id_image'] = $request->file('id_image')->store('id_images', 'public');
        }

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->fill($validated)->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        if ($user->id_image && Storage::disk('public')->exists($user->id_image)) {
            Storage::disk('public')->delete($user->id_image);
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
