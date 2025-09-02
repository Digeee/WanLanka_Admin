@extends('admin.layouts.master')

@section('title', 'Edit Guider')
@section('page-title', 'Edit Guider')

@section('content')
<div class="content-section">
    <form action="{{ route('admin.guiders.update', $guider) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div>
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ $guider->first_name }}" required>
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ $guider->last_name }}" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ $guider->email }}" required>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $guider->phone }}">
        </div>
        <div>
            <label>Experience Years</label>
            <input type="number" name="experience_years" value="{{ $guider->experience_years }}">
        </div>
        <div>
            <label>Hourly Rate ($)</label>
            <input type="number" step="0.01" name="hourly_rate" value="{{ $guider->hourly_rate }}">
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="active" {{ $guider->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $guider->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div>
            <label>Profile Image</label>
            <input type="file" name="image">
            @if($guider->image)
                <img src="{{ asset('storage/'.$guider->image) }}" width="100">
            @endif
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
