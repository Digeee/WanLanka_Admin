<!DOCTYPE html>
<html>
<head><title>Booking Update</title></head>
<body>
    <h1>Booking #{{ $booking->id }} {{ ucfirst($type) }} Update</h1>
    <p>Dear {{ $type == 'user' ? $booking->full_name : ($guider->name ?? 'Team') }},</p>

    @if($type == 'unassigned')
        <p>This booking has been unassigned. Details:</p>
    @else
        <p>Your booking has been assigned/updated:</p>
    @endif

    <ul>
        <li><strong>Date/Time:</strong> {{ $booking->date }} at {{ $booking->time }}</li>
        <li><strong>Pickup:</strong> {{ $booking->pickup_location }}, {{ $booking->pickup_district }}</li>
        <li><strong>People:</strong> {{ $booking->people_count }}</li>
        <li><strong>Vehicle:</strong> {{ $vehicle->vehicle_type ?? 'TBD' }} ({{ $vehicle->number_plate ?? '' }})</li>
        @if($guider)
            <li><strong>Guider:</strong> {{ $guider->name }} (Specializations: {{ implode(', ', $guider->specializations ?? []) }})</li>
        @endif
        <li><strong>Total Price:</strong> ${{ $booking->total_price }}</li>
    </ul>

    <p>Status: {{ ucfirst($booking->status) }}</p>
    <p>Thank you for using our service!</p>
</body>
</html>
