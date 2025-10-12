<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Status Update</title>
</head>
<body>
    @if($recipientType === 'user')
        <h3>Hello {{ $booking->first_name }} {{ $booking->last_name }},</h3>
        <p>Your booking status has been updated to <strong>{{ ucfirst($booking->status) }}</strong>.</p>
    @else
        <h3>Hello Admin,</h3>
        <p>The booking for <strong>{{ $booking->first_name }} {{ $booking->last_name }}</strong> has been updated. Current status: <strong>{{ ucfirst($booking->status) }}</strong>.</p>
    @endif

    <p>Booking Details:</p>
    <ul>
        <li>Package Name: {{ $booking->package_name }}</li>
        <li>Pickup Location: {{ $booking->pickup_location }}</li>
        <li>Participants: {{ $booking->participants }}</li>
        <li>Total Price: ${{ $booking->total_price }}</li>
        <li>Payment Method: {{ ucfirst($booking->payment_method) }}</li>
        <li>Status: {{ ucfirst($booking->status) }}</li>
    </ul>

    <p>Thank you,<br>WanLanka Team</p>
</body>
</html>
