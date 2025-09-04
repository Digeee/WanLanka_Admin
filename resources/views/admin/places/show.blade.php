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
    </style>

    <div class="container">
        <h1>Place Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $place->name }}</h5>
                <p><strong>Description:</strong> {{ $place->description ?? 'N/A' }}</p>
                <p><strong>Province:</strong> {{ $place->province ?? 'N/A' }}</p>
                <p><strong>District:</strong> {{ $place->district ?? 'N/A' }}</p>
                <p><strong>Location:</strong> {{ $place->location ?? 'N/A' }}</p>
                <p><strong>Latitude:</strong> {{ $place->latitude ?? 'N/A' }}</p>
                <p><strong>Longitude:</strong> {{ $place->longitude ?? 'N/A' }}</p>
                <p><strong>Weather:</strong> {{ $place->weather ?? 'N/A' }}</p>
                <p><strong>Travel Type:</strong> {{ $place->travel_type ?? 'N/A' }}</p>
                <p><strong>Season:</strong> {{ $place->season ?? 'N/A' }}</p>
                <p><strong>Entry Fee:</strong> ${{ number_format($place->entry_fee, 2) ?? 'N/A' }}</p>
                <p><strong>Opening Hours:</strong> {{ $place->opening_hours ?? 'N/A' }}</p>
                <p><strong>Best Time to Visit:</strong> {{ $place->best_time_to_visit ?? 'N/A' }}</p>
                <p><strong>Rating:</strong> {{ $place->rating ? number_format($place->rating, 1) : 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $place->status }}</p>
                @if ($place->image)
                    <p><strong>Image:</strong></p>
                    <img src="{{ asset('storage/' . $place->image) }}" alt="Place Image" width="200" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                @else
                    <p><strong>Image:</strong> N/A</p>
                @endif
                @if ($place->gallery)
                    <p><strong>Gallery:</strong></p>
                    <div class="gallery-preview">
                        @foreach ($place->gallery as $galleryImage)
                            <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery Image" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                        @endforeach
                    </div>
                @else
                    <p><strong>Gallery:</strong> N/A</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.places.destroy', $place) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
            </form>
            <a href="{{ route('admin.places.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection

