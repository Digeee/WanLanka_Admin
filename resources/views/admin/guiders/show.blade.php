
    <div class="container">
        <h1>Guider Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $guider->first_name }} {{ $guider->last_name }}</h5>
                <p><strong>Email:</strong> {{ $guider->email }}</p>
                <p><strong>Phone:</strong> {{ $guider->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $guider->address ?? 'N/A' }}</p>
                <p><strong>City:</strong> {{ $guider->city ?? 'N/A' }}</p>
                <p><strong>Languages:</strong> {{ $guider->languages ? implode(', ', $guider->languages) : 'N/A' }}</p>
                <p><strong>Specializations:</strong> {{ $guider->specializations ? implode(', ', $guider->specializations) : 'N/A' }}</p>
                <p><strong>Experience:</strong> {{ $guider->experience_years }} years</p>
                <p><strong>Hourly Rate:</strong> ${{ $guider->hourly_rate }}</p>
                <p><strong>Availability:</strong> {{ $guider->availability ? 'Available' : 'Not Available' }}</p>
                <p><strong>Description:</strong> {{ $guider->description ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $guider->status }}</p>
                @if ($guider->image)
                    <p><strong>Image:</strong></p>
                    <img src="{{ asset('storage/' . $guider->image) }}" alt="Guider Image" width="200">
                @else
                    <p><strong>Image:</strong> N/A</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this guider?')">Delete</button>
            </form>
            <a href="{{ route('admin.guiders.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
