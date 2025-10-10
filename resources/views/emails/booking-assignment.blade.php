<!DOCTYPE html>
<html>
<head><title>Booking Update</title></head>
<body>
    <h1>Booking #{{ $booking->id }} {{ ucfirst($type) }} Update</h1>

    @if($type == 'user')
        <p>Dear {{ $booking->full_name ?? 'Customer' }},</p>
    @elseif($type == 'guider' && $guider)
        <p>Dear {{ $guider->first_name ?? 'Guider' }} {{ $guider->last_name ?? '' }},</p>
    @elseif($type == 'unassigned' && $guider)
        <p>Dear {{ $guider->first_name ?? 'Former Guider' }} {{ $guider->last_name ?? '' }},</p>
    @else
        <p>Dear Team,</p>
    @endif

    @if($type == 'unassigned')
        <p>This booking has been unassigned from you. Details:</p>
    @else
        <p>Your booking has been assigned/updated:</p>
    @endif

    <ul>
        <li><strong>Date/Time:</strong> {{ $booking->date }} at {{ $booking->time }}</li>
        <li><strong>Pickup:</strong> {{ $booking->pickup_location }}, {{ $booking->pickup_district }}</li>
        <li><strong>People:</strong> {{ $booking->people_count }}</li>
        <li><strong>Vehicle:</strong> {{ $vehicle->vehicle_type ?? 'Not assigned yet' }} ({{ $vehicle->number_plate ?? 'N/A' }})</li>
        @if($guider && $type != 'unassigned' && is_object($guider))
            <li><strong>Guider:</strong> {{ $guider->first_name ?? '' }} {{ $guider->last_name ?? '' }} (Specializations: {{ !empty($guider->specializations) && is_array($guider->specializations) ? implode(', ', $guider->specializations) : 'None' }})</li>
        @endif
        <li><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</li>
    </ul>

    <p>Status: {{ ucfirst($booking->status) }}</p>
    <p>Thank you for using our service!</p>
</body>
</html>
