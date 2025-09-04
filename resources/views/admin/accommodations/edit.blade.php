@extends('admin.layouts.master')

@section('content')
    <style>
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 20px;
            background: #e0e0e0;
            box-shadow: 9px 9px 16px #bebebe,
                        -9px -9px 16px #ffffff;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
            color: #444;
        }
        .form-control, .form-control-file, textarea, select {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            background: #e0e0e0;
            box-shadow: inset 4px 4px 8px #bebebe,
                        inset -4px -4px 8px #ffffff;
            outline: none;
            transition: 0.3s ease;
        }
        .form-control:focus, textarea:focus, select:focus {
            box-shadow: inset 2px 2px 5px #bebebe,
                        inset -2px -2px 5px #ffffff;
        }
        .btn-primary, .btn-secondary {
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease;
            margin-top: 10px;
        }
        .btn-primary {
            background: #e0e0e0;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .btn-primary:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
        .btn-secondary {
            background: #f1f1f1;
            margin-left: 10px;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }
        .btn-secondary:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
        .alert-danger {
            padding: 15px;
            border-radius: 12px;
            background: #ffdddd;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            margin-bottom: 20px;
        }
    </style>

    <div class="container">
        <h1>Edit Accommodation</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.accommodations.update', $accommodation) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $accommodation->name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $accommodation->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="province">Province</label>
                        <select name="province" id="province" class="form-control" required>
                            <option value="" disabled>Select Province</option>
                            <option value="Northern" {{ old('province', $accommodation->province) == 'Northern' ? 'selected' : '' }}>Northern</option>
                            <option value="North Western" {{ old('province', $accommodation->province) == 'North Western' ? 'selected' : '' }}>North Western</option>
                            <option value="Western" {{ old('province', $accommodation->province) == 'Western' ? 'selected' : '' }}>Western</option>
                            <option value="North Central" {{ old('province', $accommodation->province) == 'North Central' ? 'selected' : '' }}>North Central</option>
                            <option value="Central" {{ old('province', $accommodation->province) == 'Central' ? 'selected' : '' }}>Central</option>
                            <option value="Sabaragamuwa" {{ old('province', $accommodation->province) == 'Sabaragamuwa' ? 'selected' : '' }}>Sabaragamuwa</option>
                            <option value="Eastern" {{ old('province', $accommodation->province) == 'Eastern' ? 'selected' : '' }}>Eastern</option>
                            <option value="Uva" {{ old('province', $accommodation->province) == 'Uva' ? 'selected' : '' }}>Uva</option>
                            <option value="Southern" {{ old('province', $accommodation->province) == 'Southern' ? 'selected' : '' }}>Southern</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="district">District</label>
                        <select name="district" id="district" class="form-control" required>
                            <option value="" disabled>Select District</option>
                            @if ($accommodation->district)
                                <option value="{{ $accommodation->district }}" selected>{{ $accommodation->district }}</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $accommodation->location) }}">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="number" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $accommodation->latitude) }}" step="0.00000001" min="-90" max="90">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="number" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $accommodation->longitude) }}" step="0.00000001" min="-180" max="180">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="price_per_night">Price Per Night</label>
                <input type="number" name="price_per_night" id="price_per_night" class="form-control" value="{{ old('price_per_night', $accommodation->price_per_night) }}" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="room_types">Room Types (comma-separated)</label>
                <input type="text" name="room_types[]" id="room_types" class="form-control" value="{{ old('room_types', $accommodation->room_types ? implode(',', $accommodation->room_types) : '') }}">
            </div>
            <div class="form-group">
                <label for="amenities">Amenities (comma-separated)</label>
                <input type="text" name="amenities[]" id="amenities" class="form-control" value="{{ old('amenities', $accommodation->amenities ? implode(',', $accommodation->amenities) : '') }}">
            </div>
            <div class="form-group">
                <label for="rating">Rating (0-5)</label>
                <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating', $accommodation->rating) }}" step="0.1" min="0" max="5">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                @if ($accommodation->image)
                    <div>
                        <img src="{{ asset('storage/' . $accommodation->image) }}" alt="Accommodation Image" width="100" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="reviews">Reviews (comma-separated)</label>
                <input type="text" name="reviews[]" id="reviews" class="form-control" value="{{ old('reviews', $accommodation->reviews ? implode(',', $accommodation->reviews) : '') }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Accommodation</button>
            <a href="{{ route('admin.accommodations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        const provinceDistricts = {
            'Northern': ['Jaffna', 'Kilinochchi', 'Mannar', 'Mullaitivu', 'Vavuniya'],
            'North Western': ['Puttalam', 'Kurunegala'],
            'Western': ['Gampaha', 'Colombo', 'Kalutara'],
            'North Central': ['Anuradhapura', 'Polonnaruwa'],
            'Central': ['Matale', 'Kandy', 'Nuwara Eliya'],
            'Sabaragamuwa': ['Kegalle', 'Ratnapura'],
            'Eastern': ['Trincomalee', 'Batticaloa', 'Ampara'],
            'Uva': ['Badulla', 'Monaragala'],
            'Southern': ['Hambantota', 'Matara', 'Galle']
        };

        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');

        provinceSelect.addEventListener('change', function () {
            const selectedProvince = this.value;
            districtSelect.innerHTML = '<option value="" disabled>Select District</option>';

            if (selectedProvince && provinceDistricts[selectedProvince]) {
                provinceDistricts[selectedProvince].forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    if (district === '{{ old('district', $accommodation->district) }}') {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            }
        });

        // Trigger change event on page load to populate districts
        provinceSelect.dispatchEvent(new Event('change'));
    </script>
@endsection
