@extends('admin.layouts.master')

@section('content')
    <style>
        .container {
            max-width: 1200px;
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
        .table {
            background: #e0e0e0;
            border-radius: 15px;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .table th, .table td {
            padding: 15px;
            vertical-align: middle;
            color: #333;
        }
        .btn-primary, .btn-warning, .btn-danger, .btn-secondary {
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease;
            margin-right: 5px;
        }
        .btn-primary {
            background: #e0e0e0;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .btn-primary:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
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
        .alert-success {
            padding: 15px;
            border-radius: 12px;
            background: #ddffdd;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            margin-bottom: 20px;
        }
    </style>

    <div class="container">
        <h1>Manage Places</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.places.create') }}" class="btn btn-primary mb-3">Add New Place</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($places as $place)
                    <tr>
                        <td>{{ $place->name }}</td>
                        <td>{{ $place->province ?? 'N/A' }}</td>
                        <td>{{ $place->district ?? 'N/A' }}</td>
                        <td>{{ $place->location ?? 'N/A' }}</td>
                        <td>{{ $place->rating ? number_format($place->rating, 1) : 'N/A' }}</td>
                        <td>{{ $place->status }}</td>
                        <td>
                            <a href="{{ route('admin.places.show', $place) }}" class="btn btn-secondary">View</a>
                            <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.places.destroy', $place) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No places found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $places->links() }}
    </div>
@endsection

