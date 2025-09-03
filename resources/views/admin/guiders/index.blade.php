@extends('admin.layouts.master')

@section('content')

    <style>
        body {
            background: #e0e5ec;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 20px;
            background: #e0e5ec;
            box-shadow:  10px 10px 20px #bebebe,
                        -10px -10px 20px #ffffff;
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
            text-shadow: 1px 1px 2px #fff;
        }
        .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            background: #e0e5ec;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
            transition: 0.2s ease-in-out;
            font-weight: 600;
        }
        .btn:hover {
            box-shadow: inset 5px 5px 10px #bebebe,
                        inset -5px -5px 10px #ffffff;
        }
        .btn-primary { color: #007bff; }
        .btn-info { color: #17a2b8; }
        .btn-warning { color: #ffc107; }
        .btn-danger { color: #dc3545; }
        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
        .alert {
            border-radius: 12px;
            padding: 15px;
            background: #e0e5ec;
            box-shadow: inset 5px 5px 10px #bebebe,
                        inset -5px -5px 10px #ffffff;
            color: green;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-radius: 15px;
            overflow: hidden;
            background: #e0e5ec;
            box-shadow:  8px 8px 16px #bebebe,
                        -8px -8px 16px #ffffff;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        thead {
            background: #e0e5ec;
            box-shadow: inset 2px 2px 5px #bebebe,
                        inset -2px -2px 5px #ffffff;
        }
        th {
            font-weight: 600;
            color: #444;
        }
        tr {
            transition: 0.2s;
        }
        tr:hover {
            background: #f1f3f6;
        }
        td {
            color: #333;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .pagination .page-item .page-link {
            padding: 8px 14px;
            border-radius: 12px;
            background: #e0e5ec;
            box-shadow: 3px 3px 6px #bebebe,
                        -3px -3px 6px #ffffff;
            color: #007bff;
            border: none;
        }
        .pagination .page-item.active .page-link {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            font-weight: bold;
        }
    </style>

    <div class="container">
        <h1>Guiders</h1>
        <a href="{{ route('admin.guiders.create') }}" class="btn btn-primary mb-3">+ Add New Guider</a>

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>NIC Number</th>
                    <th>Vehicle Types</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guiders as $guider)
                    <tr>
                        <td>{{ $guider->id }}</td>
                        <td>{{ $guider->first_name }} {{ $guider->last_name }}</td>
                        <td>{{ $guider->email }}</td>
                        <td>{{ $guider->phone ?? 'N/A' }}</td>
                        <td>{{ $guider->city ?? 'N/A' }}</td>
                        <td>{{ $guider->nic_number ?? 'N/A' }}</td>
                        <td>{{ $guider->vehicle_types ? implode(', ', $guider->vehicle_types) : 'N/A' }}</td>
                        <td>{{ $guider->status }}</td>
                        <td>
                            <a href="{{ route('admin.guiders.show', $guider) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this guider?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No guiders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $guiders->links() }}
    </div>
@endsection
