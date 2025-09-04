@extends('admin.layouts.master')

@section('content')
    <h1>Sliders</h1>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Add New Slider</a>

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Caption</th>
                <th>Description</th>
                <th>Button Name</th>
                <th>Button Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <td><img src="{{ asset('storage/' . $slider->image) }}" width="100"></td>
                    <td>{{ $slider->caption }}</td>
                    <td>{{ $slider->description }}</td>
                    <td>{{ $slider->button_name }}</td>
                    <td>{{ $slider->button_link }}</td>
                    <td>
                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
