@extends('admin.layouts.master')

@section('title', 'Add Guider')
@section('page-title', 'Create Guider')

@section('content')
<div class="content-section">
    <form action="{{ route('admin.guiders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>First Name</label>
            <input type="text" name="first_name" required>
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="last_name" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone">
        </div>
        <div>
            <label>Experience Years</label>
            <input type="number" name="experience_years" min="0">
        </div>
        <div>
            <label>Hourly Rate ($)</label>
            <input type="number" step="0.01" name="hourly_rate">
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div>
            <label>Profile Image</label>
            <input type="file" name="image">
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
