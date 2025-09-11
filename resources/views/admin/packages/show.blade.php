
@extends('admin.layouts.master')

@section('content')

<div>
    <h1>{{ $package->package_name }}</h1>
    <p><strong>Description:</strong> {{ $package->description ?? 'N/A' }}</p>
    <p><strong>Price:</strong> ${{ number_format($package->price, 2) }}</p>
    <p><strong>Starting Date:</strong> {{ $package->starting_date ? date('Y-m-d', strtotime($package->starting_date)) : 'N/A' }}</p>
    <p><strong>Expiry Date:</strong> {{ $package->expiry_date ? date('Y-m-d', strtotime($package->expiry_date)) : 'N/A' }}</p>
    <p><strong>Places:</strong> {{ $package->relatedPlaces->isNotEmpty() ? $package->relatedPlaces->pluck('name')->join(', ') : 'N/A' }}</p>
    <p><strong>Accommodations:</strong> {{ $package->accommodations->isNotEmpty() ? $package->accommodations->pluck('name')->join(', ') : 'N/A' }}</p>
    <p><strong>Days:</strong> {{ $package->days ?? 'N/A' }}</p>
    <p><strong>Day Plans:</strong></p>
    @if ($package->dayPlans->isNotEmpty())
        @foreach ($package->dayPlans as $dayPlan)
            <div class="day-plan">
                <h6>Day {{ $dayPlan->day_number }}</h6>
                <p><strong>Plan:</strong> {{ $dayPlan->plan ?? 'N/A' }}</p>
                <p><strong>Accommodation:</strong>
                    {{ $dayPlan->accommodation ? $dayPlan->accommodation->name . ' (' . ($dayPlan->accommodation->province ?? 'N/A') . ' - ' . ($dayPlan->accommodation->district ?? 'N/A') . ')' : 'N/A' }}
                </p>
                <p><strong>Description:</strong> {{ $dayPlan->description ?? 'N/A' }}</p>
                <p><strong>Photos:</strong>
                    @if (is_array($dayPlan->photos) && !empty($dayPlan->photos))
                        <div class="gallery-preview">
                            @foreach ($dayPlan->photos as $photo)
                                <img src="{{ asset('storage/' . $photo) }}" alt="Day Plan Photo" onerror="this.src='{{ asset('images/placeholder.jpg') }}';" style="max-width: 100px; height: auto;">
                            @endforeach
                        </div>
                    @else
                        N/A
                    @endif
                </p>
            </div>
        @endforeach
    @else
        <p>N/A</p>
    @endif
    <p><strong>Inclusions:</strong> {{ is_array($package->inclusions) && !empty($package->inclusions) ? implode(', ', $package->inclusions) : 'N/A' }}</p>
    <p><strong>Vehicle Type:</strong> {{ $package->vehicle ? $package->vehicle->type . ' (' . ($package->vehicle->license_plate ?? 'N/A') . ')' : 'N/A' }}</p>
    <p><strong>Package Type:</strong> {{ $package->package_type ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ $package->status ?? 'N/A' }}</p>
    <p><strong>Rating:</strong> {{ $package->rating ? $package->rating . ' Stars' : 'N/A' }}</p>
    <p><strong>Reviews:</strong> {{ is_array($package->reviews) && !empty($package->reviews) ? implode(', ', $package->reviews) : 'N/A' }}</p>
    <p><strong>Cover Image:</strong>
        @if ($package->cover_image)
            <img src="{{ asset('storage/' . $package->cover_image) }}" alt="Cover Image" style="max-width: 200px; height: auto;">
        @else
            N/A
        @endif
    </p>
    <p><strong>Gallery:</strong>
        @if (is_array($package->gallery) && !empty($package->gallery))
            <div class="gallery-preview">
                @foreach ($package->gallery as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" style="max-width: 100px; height: auto;">
                @endforeach
            </div>
        @else
            N/A
        @endif
    </p>
</div>

<style>
.day-plan {
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.gallery-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
</style>

@endsection
