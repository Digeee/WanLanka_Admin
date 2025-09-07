
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
        <h1>Manage Packages</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary mb-3">Add New Package</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Days</th>
                    <th>Package Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($packages as $package)
                    <tr>
                        <td>{{ $package->package_name }}</td>
                        <td>{{ $package->days }}</td>
                        <td>{{ $package->package_type }}</td>
                        <td>{{ $package->price ? number_format($package->price, 2) : 'N/A' }}</td>
                        <td>{{ $package->status }}</td>
                        <td>
                            <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-secondary">View</a>
                            <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No packages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $packages->links() }}
    </div>
@endsection
