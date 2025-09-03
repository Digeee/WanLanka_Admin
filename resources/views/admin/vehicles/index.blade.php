@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Vehicles</h1>
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary mb-3">Add New Vehicle</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Number Plate</th>
                    <th>Seat Count</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->id }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $vehicle->vehicle_type)) }}</td>
                        <td>{{ $vehicle->number_plate }}</td>
                        <td>{{ $vehicle->seat_count }}</td>
                        <td>{{ $vehicle->model ?? 'N/A' }}</td>
                        <td>{{ $vehicle->year ?? 'N/A' }}</td>
                        <td>{{ $vehicle->status }}</td>
                        <td>
                            <a href="{{ route('admin.vehicles.show', $vehicle) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No vehicles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $vehicles->links() }}
    </div>
@endsection
