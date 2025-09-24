@extends('admin.layouts.master')


@section('content')
    <div class="container">
        <h1>User Details #{{ $user->id }}</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Date of Birth:</strong> {{ $user->dob ? $user->dob->format('Y-m-d') : 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ $user->city ?? 'N/A' }}</p>
                        <p><strong>District:</strong> {{ $user->district ?? 'N/A' }}</p>
                        <p><strong>Province:</strong> {{ $user->province ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $user->country ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Emergency Contact Name:</strong> {{ $user->emergency_name ?? 'N/A' }}</p>
                        <p><strong>Emergency Contact Phone:</strong> {{ $user->emergency_phone ?? 'N/A' }}</p>
                        <p><strong>ID Type:</strong> {{ $user->id_type ?? 'N/A' }}</p>
                        <p><strong>ID Number:</strong> {{ $user->id_number ?? 'N/A' }}</p>
                        <p><strong>Preferred Language:</strong> {{ $user->preferred_language ?? 'N/A' }}</p>
                        <p><strong>Marketing Opt-In:</strong> {{ $user->marketing_opt_in ? 'Yes' : 'No' }}</p>
                        <p><strong>Accept Terms:</strong> {{ $user->accept_terms ? 'Yes' : 'No' }}</p>
                        <p><strong>Verified:</strong> {{ $user->is_verified ? 'Yes' : 'No' }}</p>
                        <p><strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                        <p><strong>Updated At:</strong> {{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Profile Photo:</strong></p>
                        <img src="{{ $user->profile_photo_url }}" alt="Profile" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="col-md-6">
                        <p><strong>ID Image:</strong></p>
                        @if($user->id_image)
                            <img src="{{ $user->id_image_url }}" alt="ID" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <p>N/A</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
        </div>
    </div>
@endsection
