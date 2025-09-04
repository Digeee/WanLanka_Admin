@extends('admin.layouts.master')

@section('content')
    <style>
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 20px;
            background: #e0e0e0;
            box-shadow: 9px 9px 16px #bebebe,
                        -9px -9px 16px #ffffff;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }
        .card {
            background: #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .card h5 {
            color: #444;
            font-weight: 500;
        }
        .card p {
            color: #333;
        }
        .btn-warning, .btn-danger, .btn-secondary {
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease;
            margin-right: 10px;
        }
        .btn-warning {
            background: #e0e0e0;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .btn-warning:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
        .btn-danger {
            background: #ffdddd;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .btn-danger:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
        .btn-secondary {
            background: #f1f1f1;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .btn-secondary:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
    </style>

    <div class="container">
        <h1>Guider Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $guider->first_name }} {{ $guider->last_name }}</h5>
                <p><strong>Email:</strong> {{ $guider->email }}</p>
                <p><strong>Phone:</strong> {{ $guider->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $guider->address ?? 'N/A' }}</p>
                <p><strong>City:</strong> {{ $guider->city ?? 'N/A' }}</p>
                <p><strong>Languages:</strong> {{ $guider->languages ? implode(', ', $guider->languages) : 'N/A' }}</p>
                <p><strong>Specializations:</strong> {{ $guider->specializations ? implode(', ', $guider->specializations) : 'N/A' }}</p>
                <p><strong>Experience:</strong> {{ $guider->experience_years }} years</p>
                <p><strong>Hourly Rate:</strong> ${{ number_format($guider->hourly_rate, 2) }}</p>
                <p><strong>Availability:</strong> {{ $guider->availability ? 'Available' : 'Not Available' }}</p>
                <p><strong>Description:</strong> {{ $guider->description ?? 'N/A' }}</p>
                <p><strong>NIC Number:</strong> {{ $guider->nic_number ?? 'N/A' }}</p>
                <p><strong>Vehicle Types:</strong> {{ $guider->vehicle_types ? implode(', ', $guider->vehicle_types) : 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $guider->status }}</p>
                @if ($guider->image)
                    <p><strong>Image:</strong></p>
                    <img src="{{ asset('storage/' . $guider->image) }}" alt="Guider Image" width="200" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                @else
                    <p><strong>Image:</strong> N/A</p>
                @endif
                @if ($guider->driving_license_photo)
                    <p><strong>Driving License Photo:</strong></p>
                    <img src="{{ asset('storage/' . $guider->driving_license_photo) }}" alt="Driving License Photo" width="200" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                @else
                    <p><strong>Driving License Photo:</strong> N/A</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this guider?')">Delete</button>
            </form>
            <a href="{{ route('admin.guiders.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
