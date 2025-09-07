
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
        .gallery-preview img {
            width: 100px;
            margin-right: 10px;
            margin-bottom: 10px;
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
        .day-plan {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            background: #f1f1f1;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
    </style>

    <div class="container">
        <h1>Package Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $package->package_name }}</h5>
                <p><strong>Description:</strong> {{ $package->description ?? 'N/A' }}</p>
                <p><strong>Price:</strong> ${{ number_format($package->price, 2) ?? 'N/A' }}</p>
                <p><strong>Starting Date:</strong> {{ $package->starting_date ?? 'N/A' }}</p>
                <p><strong>Expiry Date:</strong> {{ $package->expiry_date ?? 'N/A' }}</p>
                <p><strong>Places:</strong> {{ $package->relatedPlaces->pluck('name')->implode(', ') ?: 'N/A' }}</p>
                <p><strong>Accommodations:</strong> {{ $package->accommodations->pluck('name')->implode(', ') ?: 'N/A' }}</p>
                <p><strong>Days:</strong> {{ $package->days }}</p>
                @if ($package->day_plans)
                    <h5>Day Plans:</h5>
                    @foreach ($package->day_plans as $index => $dayPlan)
                        <div class="day-plan">
                            <h6>Day {{ $index + 1 }}</h6>
                            <p><strong>Plan:</strong> {{ $dayPlan['plan'] ?? 'N/A' }}</p>
                            <p><strong>Accommodation:</strong>
                                @php
                                    $accommodation = $package->accommodations->find($dayPlan['accommodation_id']);
                                @endphp
                                {{ $accommodation ? $accommodation->name . ' (' . $accommodation->province . ' - ' . $accommodation->district . ')' : 'N/A' }}
                            </p>
                            <p><strong>Description:</strong> {{ $dayPlan['description'] ?? 'N/A' }}</p>
                            @if (!empty($dayPlan['photos']))
                                <p><strong>Photos:</strong></p>
                                <div class="gallery-preview">
                                    @foreach ($dayPlan['photos'] as $photo)
                                        <img src="{{ asset('storage/' . $photo) }}" alt="Day Plan Photo" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                                    @endforeach
                                </div>
                            @else
                                <p><strong>Photos:</strong> N/A</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p><strong>Day Plans:</strong> N/A</p>
                @endif
                <p><strong>Inclusions:</strong> {{ $package->inclusions ? implode(', ', $package->inclusions) : 'N/A' }}</p>
                <p><strong>Vehicle Type:</strong> {{ $package->vehicle ? $package->vehicle->vehicle_type . ' (' . $package->vehicle->model . ' - ' . $package->vehicle->number_plate . ')' : 'N/A' }}</p>
                <p><strong>Package Type:</strong> {{ $package->package_type }}</p>
                <p><strong>Status:</strong> {{ $package->status }}</p>
                <p><strong>Rating:</strong> {{ $package->rating ? number_format($package->rating, 1) : 'N/A' }}</p>
                <p><strong>Reviews:</strong> {{ $package->reviews ? implode(', ', $package->reviews) : 'N/A' }}</p>
                @if ($package->cover_image)
                    <p><strong>Cover Image:</strong></p>
                    <img src="{{ asset('storage/' . $package->cover_image) }}" alt="Cover Image" width="200" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                @else
                    <p><strong>Cover Image:</strong> N/A</p>
                @endif
                @if ($package->gallery)
                    <p><strong>Gallery:</strong></p>
                    <div class="gallery-preview">
                        @foreach ($package->gallery as $galleryImage)
                            <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                        @endforeach
                    </div>
                @else
                    <p><strong>Gallery:</strong> N/A</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">Delete</button>
            </form>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
