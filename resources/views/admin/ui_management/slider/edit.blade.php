@extends('admin.layouts.master')

@section('content')
    <h1>Edit Slider</h1>
    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ asset('storage/' . $slider->image) }}" width="100" alt="Current Image">
        </div>
        <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" name="caption" class="form-control" value="{{ $slider->caption }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $slider->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="button_name">Button Name</label>
            <input type="text" name="button_name" class="form-control" value="{{ $slider->button_name }}" required>
        </div>
        <div class="form-group">
            <label for="button_link">Button Link</label>
            <input type="url" name="button_link" class="form-control" value="{{ $slider->button_link }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
