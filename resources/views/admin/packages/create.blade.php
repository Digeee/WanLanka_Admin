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
        .day-plan {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            background: #f1f1f1;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
        }
    </style>

    <div class="container">
        <h1>Add New Package</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="package_name">Package Name</label>
                <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Base Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="gallery">Gallery (multiple images)</label>
                <input type="file" name="gallery[]" id="gallery" class="form-control-file" multiple>
            </div>
            <div class="form-group">
                <label for="starting_date">Starting Date</label>
                <input type="date" name="starting_date" id="starting_date" class="form-control" value="{{ old('starting_date') }}">
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
            </div>
            <div class="form-group">
                <label for="related_places">Places</label>
                <select name="related_places[]" id="related_places" class="form-control" multiple required>
                    @foreach ($places as $place)
                        <option value="{{ $place->id }}" {{ in_array($place->id, old('related_places', [])) ? 'selected' : '' }}>
                            {{ $place->name }} ({{ $place->province }} - {{ $place->district }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="accommodations">Accommodations</label>
                <select name="accommodations[]" id="accommodations" class="form-control" multiple required>
                    @foreach ($accommodations as $accommodation)
                        <option value="{{ $accommodation->id }}" {{ in_array($accommodation->id, old('accommodations', [])) ? 'selected' : '' }}>
                            {{ $accommodation->name }} ({{ $accommodation->province }} - {{ $accommodation->district }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="days">Number of Days</label>
                <input type="number" name="days" id="days" class="form-control" value="{{ old('days', 1) }}" min="1" required>
            </div>
            <div id="day-plans-container">
                <!-- Dynamic day plans will be injected here -->
            </div>
            <div class="form-group">
                <label for="inclusions">Inclusions (comma-separated)</label>
                <input type="text" name="inclusions[]" id="inclusions" class="form-control" value="{{ old('inclusions') ? implode(',', old('inclusions')) : '' }}">
            </div>
            <div class="form-group">
                <label for="vehicle_type_id">Vehicle Type</label>
                <select name="vehicle_type_id" id="vehicle_type_id" class="form-control" required>
                    <option value="" {{ old('vehicle_type_id') ? '' : 'selected' }}>Select Vehicle</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_type_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->vehicle_type }} ({{ $vehicle->model }} - {{ $vehicle->number_plate }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="package_type">Package Type</label>
                <select name="package_type" id="package_type" class="form-control" required>
                    <option value="low_budget" {{ old('package_type', 'custom') == 'low_budget' ? 'selected' : '' }}>Low Budget</option>
                    <option value="high_budget" {{ old('package_type', 'custom') == 'high_budget' ? 'selected' : '' }}>High Budget</option>
                    <option value="custom" {{ old('package_type', 'custom') == 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" {{ old('status', 'draft') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', 'draft') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Rating (0-5)</label>
                <input type="number" name="rating" id="rating" class="form-control" value="{{ old('rating') }}" step="0.1" min="0" max="5">
            </div>
            <div class="form-group">
                <label for="reviews">Reviews (comma-separated)</label>
                <input type="text" name="reviews[]" id="reviews" class="form-control" value="{{ old('reviews') ? implode(',', old('reviews')) : '' }}">
            </div>
            <button type="submit" class="btn btn-primary">Save Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        const daysInput = document.getElementById('days');
        const dayPlansContainer = document.getElementById('day-plans-container');
        const oldDayPlans = @json(old('day_plans', []));
        const accommodations = @json($accommodations);

        function updateDayPlans() {
            const days = parseInt(daysInput.value) || 1;
            dayPlansContainer.innerHTML = '';

            for (let i = 0; i < days; i++) {
                const dayPlan = oldDayPlans[i] || {};
                const dayPlanDiv = document.createElement('div');
                dayPlanDiv.className = 'day-plan';
                dayPlanDiv.innerHTML = `
                    <h4>Day ${i + 1}</h4>
                    <div class="form-group">
                        <label for="day_plans[${i}][plan]">Plan</label>
                        <textarea name="day_plans[${i}][plan]" id="day_plans[${i}][plan]" class="form-control">${dayPlan.plan || ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="day_plans[${i}][accommodation_id]">Accommodation</label>
                        <select name="day_plans[${i}][accommodation_id]" id="day_plans[${i}][accommodation_id]" class="form-control">
                            <option value="" ${!dayPlan.accommodation_id ? 'selected' : ''}>Select Accommodation</option>
                            ${accommodations.map(accommodation => `
                                <option value="${accommodation.id}" ${dayPlan.accommodation_id == accommodation.id ? 'selected' : ''}>
                                    ${accommodation.name} (${accommodation.province} - ${accommodation.district})
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day_plans[${i}][description]">Description</label>
                        <textarea name="day_plans[${i}][description]" id="day_plans[${i}][description]" class="form-control">${dayPlan.description || ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="day_plans[${i}][photos][]">Photos</label>
                        <input type="file" name="day_plans[${i}][photos][]" id="day_plans[${i}][photos]" class="form-control-file" multiple>
                    </div>
                `;
                dayPlansContainer.appendChild(dayPlanDiv);
            }
        }

        daysInput.addEventListener('input', updateDayPlans);
        updateDayPlans();
    </script>
@endsection
