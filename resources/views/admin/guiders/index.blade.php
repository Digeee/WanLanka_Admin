
@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <h1>Guiders</h1>
        <a href="{{ route('admin.guiders.create') }}" class="btn btn-primary mb-3">Add New Guider</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
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
