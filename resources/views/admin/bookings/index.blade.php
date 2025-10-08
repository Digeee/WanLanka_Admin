@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Booking Management</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Place</th>
                    <th>Pickup District</th>
                    <th>Pickup Location</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Coordinates</th>
                    <th>People</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Vehicle</th>
                    <th>Guider</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking['id'] }}</td>
                        <td>{{ $booking['place_name'] }}</td>
                        <td>{{ $booking['pickup_district'] }}</td>
                        <td>{{ $booking['pickup_location'] }}</td>
                        <td>{{ $booking['full_name'] ?? 'N/A' }}</td>
                        <td>{{ $booking['email'] ?? 'N/A' }}</td>
                        <td>{{ $booking['latitude'] ?? 'N/A' }}, {{ $booking['longitude'] ?? 'N/A' }}</td>
                        <td>{{ $booking['people_count'] }}</td>
                        <td>{{ $booking['date'] }}</td>
                        <td>{{ $booking['time'] }}</td>
                        <td>{{ $booking['vehicle_type'] }}</td>
                        <td>{{ $booking['guider'] }}</td>
                        <td>${{ $booking['total_price'] }}</td>
                        <td>{{ $booking['status'] }}</td>
                        <td>{{ $booking['created_at'] }}</td>
                        <td>
                            <a href="{{ route('admin.bookings.edit', $booking['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.bookings.destroy', $booking['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
