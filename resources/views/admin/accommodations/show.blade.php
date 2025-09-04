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
        <h1>Accommodation Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $accommodation->name }}</h5>
                <p><strong>Description:</strong> {{ $accommodation->description ?? 'N/A' }}</p>
                <p><strong>Province:</strong> {{ $accommodation->province ?? 'N/A' }}</p>
                <p><strong>District:</strong> {{ $accommodation->district ?? 'N/A' }}</p>
                <p><strong>Location:</strong> {{ $accommodation->location ?? 'N/A' }}</p>
                <p><strong>Latitude:</strong> {{ $accommodation->latitude ?? 'N/A' }}</p>
                <p><strong>Longitude:</strong> {{ $accommodation->longitude ?? 'N/A' }}</p>
                <p><strong>Price Per Night:</strong> ${{ number_format($accommodation->price_per_night, 2) }}</p>
                <p><strong>Room Types:</strong> {{ $accommodation->room_types ? implode(', ', $accommodation->room_types) : 'N/A' }}</p>
                <p><strong>Amenities:</strong> {{ $accommodation->amenities ? implode(', ', $accommodation->amenities) : 'N/A' }}</p>
                <p><strong>Rating:</strong> {{ $accommodation->rating ? number_format($accommodation->rating, 1) : 'N/A' }}</p>
                @if ($accommodation->image)
                    <p><strong>Image:</strong></p>
                    <img src="{{ asset('storage/' . $accommodation->image) }}" alt="Accommodation Image" width="200" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                @else
                    <p><strong>Image:</strong> N/A</p>
                @endif
                <p><strong>Reviews:</strong> {{ $accommodation->reviews ? implode(', ', $accommodation->reviews) : 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.accommodations.edit', $accommodation) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.accommodations.destroy', $accommodation) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this accommodation?')">Delete</button>
            </form>
            <a href="{{ route('admin.accommodations.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
