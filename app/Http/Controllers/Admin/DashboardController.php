<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guider;
use App\Models\Vehicle;
use App\Models\Accommodation;
use App\Models\Place;
use App\Models\Package;
use App\Models\User;
use App\Models\Booking; // Make sure this model exists (adjust if your booking model has a different name)
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Existing counts
        $guiderCount = Guider::count();
        $vehicleCount = Vehicle::count();
        $accommodationCount = Accommodation::count();
        $placeCount = Place::count();
        $packageCount = Package::count();
        $userCount = User::count();

        // ===== Recent Activities =====
        // We'll combine recent events from multiple models
        $recentActivities = collect();

        // Example: New guiders (last 7 days)
        Guider::latest()->take(3)->get()->each(function ($guider) use ($recentActivities) {
            $recentActivities->push([
                'title' => 'New Guider Added',
                'description' => $guider->name,
                'time' => $guider->created_at,
                'type' => 'guider'
            ]);
        });

        // Example: New users (last 7 days)
        User::where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(3)
            ->get()
            ->each(function ($user) use ($recentActivities) {
                $recentActivities->push([
                    'title' => 'New User Registered',
                    'description' => $user->name ?? $user->email,
                    'time' => $user->created_at,
                    'type' => 'user'
                ]);
            });

        // Example: New packages
        Package::latest()->take(2)->get()->each(function ($package) use ($recentActivities) {
            $recentActivities->push([
                'title' => 'New Package Created',
                'description' => $package->title,
                'time' => $package->created_at,
                'type' => 'package'
            ]);
        });

        // Sort by time (newest first) and limit to 6
        $recentActivities = $recentActivities
            ->sortByDesc('time')
            ->take(6)
            ->values();

        // ===== Notifications =====
        // For now, reuse recent activities as notifications (or create a real Notification model later)
        $notifications = $recentActivities->map(function ($item) {
            return [
                'title' => $item['title'],
                'message' => $item['description'],
                'type' => $item['type'],
                'created_at' => $item['time'],
                'read' => false // you can add a `read` column later
            ];
        })->all();

        $unreadNotificationsCount = count($notifications); // or filter by `read = false` if you track it

        return view('admin.dashboard', compact(
            'guiderCount',
            'vehicleCount',
            'accommodationCount',
            'placeCount',
            'packageCount',
            'userCount',
            'recentActivities',
            'notifications',
            'unreadNotificationsCount'
        ));
    }
}
