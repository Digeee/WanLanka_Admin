@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Add New Vehicle</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="vehicle_type">Vehicle Type</label>
                <select name="vehicle_type" id="vehicle_type" class="form-control" required>
                    <option value="bike" {{ old('vehicle_type') == 'bike' ? 'selected' : '' }}>Bike</option>
                    <option value="three_wheeler" {{ old('vehicle_type') == 'three_wheeler' ? 'selected' : '' }}>Three Wheeler</option>
                    <option value="car" {{ old('vehicle_type') == 'car' ? 'selected' : '' }}>Car</option>
                    <option value="van" {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                    <option value="bus" {{ old('vehicle_type') == 'bus' ? 'selected' : '' }}>Bus</option>
                </select>
            </div>
            <div class="form-group">
                <label for="number_plate">Number Plate</label>
                <input type="text" name="number_plate" id="number_plate" class="form-control" value="{{ old('number_plate') }}" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="seat_count">Seat Count</label>
                <input type="number" name="seat_count" id="seat_count" class="form-control" value="{{ old('seat_count', 1) }}" min="1" required>
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}">
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" name="year" id="year" class="form-control" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}">
            </div>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Vehicle</button>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
