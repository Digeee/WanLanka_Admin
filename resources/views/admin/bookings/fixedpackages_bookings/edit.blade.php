@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Edit Fixed Package Booking #{{ $booking->id }}</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('admin.fixedpackage.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="package_name" class="form-label">Package Name</label>
                <input type="text" class="form-control" id="package_name" name="package_name" value="{{ $booking->package_name ?? '' }}" disabled>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $booking->first_name }}" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $booking->last_name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $booking->email }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $booking->phone }}" required>
            </div>
            <div class="mb-3">
                <label for="pickup_location" class="form-label">Pickup Location</label>
                <input type="text" class="form-control" id="pickup_location" name="pickup_location" value="{{ $booking->pickup_location }}" required>
            </div>
            <div class="mb-3">
                <label for="participants" class="form-label">Number of Participants</label>
                <input type="number" class="form-control" id="participants" name="participants" value="{{ $booking->participants }}" min="1" required>
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price ($)</label>
                <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" value="{{ $booking->total_price }}" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="credit_card" {{ $booking->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    <option value="paypal" {{ $booking->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="bank_transfer" {{ $booking->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="cash" {{ $booking->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="receipt" class="form-label">Receipt</label>
                <input type="text" class="form-control" id="receipt" name="receipt" value="{{ $booking->receipt ?? '' }}">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this booking?')">Update Booking</button>
            <a href="{{ route('admin.fixedpackage.bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection