<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guider;
use App\Models\Vehicle;
use App\Models\Accommodation;
use App\Models\Place;
use App\Models\Package;
use App\Models\User;
use App\Models\Booking;
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
        $bookingCount = Booking::count();

        // ===== Recent Activities =====
        // We'll combine recent events from multiple models
        $recentActivities = collect();

        // Example: New bookings (last 7 days)
        Booking::latest()->take(3)->get()->each(function ($booking) use ($recentActivities) {
            $recentActivities->push([
                'title' => 'New Booking Created',
                'description' => 'Booking #' . $booking->id . ' for ' . ($booking->full_name ?? 'Unknown User'),
                'time' => $booking->created_at,
                'type' => 'booking'
            ]);
        });

        // Example: New guiders (last 7 days)
        Guider::latest()->take(2)->get()->each(function ($guider) use ($recentActivities) {
            $recentActivities->push([
                'title' => 'New Guider Added',
                'description' => $guider->first_name . ' ' . $guider->last_name,
                'time' => $guider->created_at,
                'type' => 'guider'
            ]);
        });

        // Example: New users (last 7 days)
        User::where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(2)
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
        Package::latest()->take(1)->get()->each(function ($package) use ($recentActivities) {
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

        // ===== Booking Statistics =====
        $todayBookings = Booking::whereDate('created_at', today())->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        return view('admin.dashboard', compact(
            'guiderCount',
            'vehicleCount',
            'accommodationCount',
            'placeCount',
            'packageCount',
            'userCount',
            'bookingCount',
            'recentActivities',
            'notifications',
            'unreadNotificationsCount',
            'todayBookings',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings'
        ));
    }
}
