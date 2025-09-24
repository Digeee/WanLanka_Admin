@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>User Management</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add New User</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>District</th>
                    <th>Verified</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['phone'] ?? 'N/A' }}</td>
                        <td>{{ $user['district'] ?? 'N/A' }}</td>
                        <td>{{ $user['is_verified'] }}</td>
                        <td>{{ $user['created_at'] }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user['id']) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.users.edit', $user['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
