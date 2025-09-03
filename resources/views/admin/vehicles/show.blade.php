@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Vehicle Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ ucfirst(str_replace('_', ' ', $vehicle->vehicle_type)) }} - {{ $vehicle->number_plate }}</h5>
                <p><strong>Seat Count:</strong> {{ $vehicle->seat_count }}</p>
                <p><strong>Model:</strong> {{ $vehicle->model ?? 'N/A' }}</p>
                <p><strong>Year:</strong> {{ $vehicle->year ?? 'N/A' }}</p>
                <p><strong>Color:</strong> {{ $vehicle->color ?? 'N/A' }}</p>
                <p><strong>Description:</strong> {{ $vehicle->description ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $vehicle->status }}</p>
                @if ($vehicle->photo)
                    <p><strong>Photo:</strong></p>
                    <img src="{{ asset('storage/' . $vehicle->photo) }}" alt="Vehicle Photo" width="200">
                @else
                    <p><strong>Photo:</strong> N/A</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete</button>
            </form>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
