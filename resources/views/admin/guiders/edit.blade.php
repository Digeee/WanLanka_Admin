
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
                <input type="number" name="experience_years" id="experience_years" class="form-control" value="{{ old('experience_years', $guider->experience_years) }}" min="0">
            </div>
            <div class="form-group">
                <label for="hourly_rate">Hourly Rate</label>
                <input type="number" name="hourly_rate" id="hourly_rate" class="form-control" value="{{ old('hourly_rate', $guider->hourly_rate) }}" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="availability">Availability</label>
                <select name="availability" id="availability" class="form-control">
                    <option value="1" {{ old('availability', $guider->availability) ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ !old('availability', $guider->availability) ? 'selected' : '' }}>Not Available</option>
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
                        <img src="{{ asset('storage/' . $guider->image) }}" alt="Guider Image" width="100">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="active" {{ old('status', $guider->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $guider->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Guider</button>
            <a href="{{ route('admin.guiders.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
