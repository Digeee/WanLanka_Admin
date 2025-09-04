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
        .form-control, .form-control-file, .form-check-input, textarea, select {
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
        .form-check-input {
            width: auto;
            margin-right: 10px;
            cursor: pointer;
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
        <h1>Edit Guider</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.guiders.update', $guider) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $guider->first_name) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $guider->last_name) }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $guider->email) }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $guider->phone) }}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $guider->address) }}">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $guider->city) }}">
            </div>
            <div class="form-group">
                <label for="languages">Languages (comma-separated)</label>
                <input type="text" name="languages[]" id="languages" class="form-control" value="{{ old('languages', $guider->languages ? implode(',', $guider->languages) : '') }}">
            </div>
            <div class="form-group">
                <label for="specializations">Specializations (comma-separated)</label>
                <input type="text" name="specializations[]" id="specializations" class="form-control" value="{{ old('specializations', $guider->specializations ? implode(',', $guider->specializations) : '') }}">
            </div>
            <div class="form-group">
                <label for="experience_years">Experience (Years)</label>
                <input type="number" name="experience_years" id="experience_years" class="form-control" value="{{ old('experience_years', $guider->experience_years) }}" min="0" required>
            </div>
            <div class="form-group">
                <label for="hourly_rate">Hourly Rate</label>
                <input type="number" name="hourly_rate" id="hourly_rate" class="form-control" value="{{ old('hourly_rate', $guider->hourly_rate) }}" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="availability">Availability</label>
                <select name="availability" id="availability" class="form-control" required>
                    <option value="1" {{ old('availability', $guider->availability) ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ old('availability', $guider->availability) ? '' : 'selected' }}>Not Available</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $guider->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                @if ($guider->image)
                    <div>
                        <img src="{{ asset('storage/' . $guider->image) }}" alt="Guider Image" width="100" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="nic_number">NIC Number</label>
                <input type="text" name="nic_number" id="nic_number" class="form-control" value="{{ old('nic_number', $guider->nic_number) }}">
            </div>
            <div class="form-group">
                <label for="driving_license_photo">Driving License Photo</label>
                @if ($guider->driving_license_photo)
                    <div>
                        <img src="{{ asset('storage/' . $guider->driving_license_photo) }}" alt="Driving License Photo" width="100" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    </div>
                @endif
                <input type="file" name="driving_license_photo" id="driving_license_photo" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Vehicle Types</label>
                <div class="form-check">
                    <input type="checkbox" name="vehicle_types[]" id="vehicle_bike" value="bike" class="form-check-input" {{ in_array('bike', old('vehicle_types', $guider->vehicle_types ?? [])) ? 'checked' : '' }}>
                    <label for="vehicle_bike" class="form-check-label">Bike</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="vehicle_types[]" id="vehicle_auto" value="auto" class="form-check-input" {{ in_array('auto', old('vehicle_types', $guider->vehicle_types ?? [])) ? 'checked' : '' }}>
                    <label for="vehicle_auto" class="form-check-label">Auto</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="vehicle_types[]" id="vehicle_car" value="car" class="form-check-input" {{ in_array('car', old('vehicle_types', $guider->vehicle_types ?? [])) ? 'checked' : '' }}>
                    <label for="vehicle_car" class="form-check-label">Car</label>
                </div>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" {{ old('status', $guider->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $guider->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Guider</button>
            <a href="{{ route('admin.guiders.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
