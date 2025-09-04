@extends('admin.layouts.master')

@section('content')
    <h1>Create New Slider</h1>
    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" name="caption" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="button_name">Button Name</label>
            <input type="text" name="button_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="button_link">Button Link</label>
            <input type="url" name="button_link" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
