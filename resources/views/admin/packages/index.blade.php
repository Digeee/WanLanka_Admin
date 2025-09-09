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
        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #f1f1f1;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            border-radius: 10px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #e0e0e0;
            font-weight: 600;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-right: 5px;
        }
        .btn-secondary {
            background: #e0e0e0;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
            color: #333;
        }
        .btn-warning {
            background: #f7d794;
            color: #333;
        }
        .btn-danger {
            background: #ff6b6b;
            color: #fff;
        }
        .btn:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .pagination .page-link {
            border-radius: 10px;
            margin: 0 5px;
            background: #e0e0e0;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
            color: #333;
        }
        .pagination .page-link:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
    </style>

    <div class="container">
        <h1>Packages</h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">Create New Package</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Days</th>
                    <th>Type</th>
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

        <div class="pagination">
            {{ $packages->links() }}
        </div>
    </div>
@endsection
