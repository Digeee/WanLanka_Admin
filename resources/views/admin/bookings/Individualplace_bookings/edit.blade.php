@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Edit Booking #{{ $booking->id }}</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Place</label>
                <input type="text" class="form-control" value="{{ $place ? $place->name : 'Unknown' }}" disabled>
            </div>
            <div class="mb-3">
                <label for="pickup_district" class="form-label">Pickup District</label>
                <select class="form-select" id="pickup_district" name="pickup_district" required>
                    <option value="">Select District</option>
                    <option value="Colombo" {{ $booking->pickup_district == 'Colombo' ? 'selected' : '' }}>Colombo</option>
                    <option value="Gampaha" {{ $booking->pickup_district == 'Gampaha' ? 'selected' : '' }}>Gampaha</option>
                    <option value="Kalutara" {{ $booking->pickup_district == 'Kalutara' ? 'selected' : '' }}>Kalutara</option>
                    <option value="Kandy" {{ $booking->pickup_district == 'Kandy' ? 'selected' : '' }}>Kandy</option>
                    <option value="Matale" {{ $booking->pickup_district == 'Matale' ? 'selected' : '' }}>Matale</option>
                    <option value="Nuwara Eliya" {{ $booking->pickup_district == 'Nuwara Eliya' ? 'selected' : '' }}>Nuwara Eliya</option>
                    <option value="Galle" {{ $booking->pickup_district == 'Galle' ? 'selected' : '' }}>Galle</option>
                    <option value="Matara" {{ $booking->pickup_district == 'Matara' ? 'selected' : '' }}>Matara</option>
                    <option value="Hambantota" {{ $booking->pickup_district == 'Hambantota' ? 'selected' : '' }}>Hambantota</option>
                    <option value="Jaffna" {{ $booking->pickup_district == 'Jaffna' ? 'selected' : '' }}>Jaffna</option>
                    <option value="Mannar" {{ $booking->pickup_district == 'Mannar' ? 'selected' : '' }}>Mannar</option>
                    <option value="Vavuniya" {{ $booking->pickup_district == 'Vavuniya' ? 'selected' : '' }}>Vavuniya</option>
                    <option value="Mullaitivu" {{ $booking->pickup_district == 'Mullaitivu' ? 'selected' : '' }}>Mullaitivu</option>
                    <option value="Kilinochchi" {{ $booking->pickup_district == 'Kilinochchi' ? 'selected' : '' }}>Kilinochchi</option>
                    <option value="Batticaloa" {{ $booking->pickup_district == 'Batticaloa' ? 'selected' : '' }}>Batticaloa</option>
                    <option value="Ampara" {{ $booking->pickup_district == 'Ampara' ? 'selected' : '' }}>Ampara</option>
                    <option value="Trincomalee" {{ $booking->pickup_district == 'Trincomalee' ? 'selected' : '' }}>Trincomalee</option>
                    <option value="Kurunegala" {{ $booking->pickup_district == 'Kurunegala' ? 'selected' : '' }}>Kurunegala</option>
                    <option value="Puttalam" {{ $booking->pickup_district == 'Puttalam' ? 'selected' : '' }}>Puttalam</option>
                    <option value="Anuradhapura" {{ $booking->pickup_district == 'Anuradhapura' ? 'selected' : '' }}>Anuradhapura</option>
                    <option value="Polonnaruwa" {{ $booking->pickup_district == 'Polonnaruwa' ? 'selected' : '' }}>Polonnaruwa</option>
                    <option value="Badulla" {{ $booking->pickup_district == 'Badulla' ? 'selected' : '' }}>Badulla</option>
                    <option value="Monaragala" {{ $booking->pickup_district == 'Monaragala' ? 'selected' : '' }}>Monaragala</option>
                    <option value="Ratnapura" {{ $booking->pickup_district == 'Ratnapura' ? 'selected' : '' }}>Ratnapura</option>
                    <option value="Kegalle" {{ $booking->pickup_district == 'Kegalle' ? 'selected' : '' }}>Kegalle</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pickup_location" class="form-label">Pickup Location</label>
                <input type="text" class="form-control" id="pickup_location" name="pickup_location" value="{{ $booking->pickup_location }}" required>
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $booking->full_name ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $booking->email ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="people_count" class="form-label">Number of People</label>
                <input type="number" class="form-control" id="people_count" name="people_count" value="{{ $booking->people_count }}" min="1" max="12" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $booking->date }}" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" class="form-control" id="time" name="time" value="{{ $booking->time }}" required>
            </div>
            <div class="mb-3">
                <label for="vehicle_id" class="form-label">Vehicle</label>
                <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ $booking->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->vehicle_type }} ({{ $vehicle->seat_count }} seats, {{ $vehicle->number_plate }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="guider" class="form-label">Guider Required</label>
                <select class="form-select" id="guider" name="guider" required onchange="toggleGuiderSection()">
                    <option value="no" {{ $booking->guider == 'no' ? 'selected' : '' }}>No</option>
                    <option value="yes" {{ $booking->guider == 'yes' ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
          <div id="guiderSection" style="display: {{ $booking->guider == 'yes' ? 'block' : 'none' }};">
    <div class="mb-3">
        <label for="guider_id" class="form-label">Assign Guider</label>
        <select class="form-select" id="guider_id" name="guider_id">
            <option value="">Select Guider</option>
            @forelse($guiders as $guider)
                <option value="{{ $guider->id }}" {{ $booking->guider_id == $guider->id ? 'selected' : '' }}>
                    {{ $guider->first_name . ' ' . $guider->last_name }} ({{ $guider->email }}) - Specializations: {{ $guider->specializations ? implode(', ', $guider->specializations) : 'None' }} - Availability: {{ $guider->availability ? 'Yes' : 'No' }}
                </option>
            @empty
                <option disabled>No available guiders found. Create some in /admin/guiders.</option>
            @endforelse
        </select>
    </div>
</div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price ($)</label>
                <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" value="{{ $booking->total_price }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Booking</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

        <script>
            function toggleGuiderSection() {
                const guiderSelect = document.getElementById('guider');
                const section = document.getElementById('guiderSection');
                section.style.display = guiderSelect.value === 'yes' ? 'block' : 'none';
            }
        </script>
    </div>
@endsection
