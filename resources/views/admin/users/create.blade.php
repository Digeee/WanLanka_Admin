@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Add New User</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select class="form-select" id="district" name="district">
                    <option value="">Select District</option>
                    <option value="Colombo" {{ old('district') == 'Colombo' ? 'selected' : '' }}>Colombo</option>
                    <option value="Gampaha" {{ old('district') == 'Gampaha' ? 'selected' : '' }}>Gampaha</option>
                    <option value="Kalutara" {{ old('district') == 'Kalutara' ? 'selected' : '' }}>Kalutara</option>
                    <option value="Kandy" {{ old('district') == 'Kandy' ? 'selected' : '' }}>Kandy</option>
                    <option value="Matale" {{ old('district') == 'Matale' ? 'selected' : '' }}>Matale</option>
                    <option value="Nuwara Eliya" {{ old('district') == 'Nuwara Eliya' ? 'selected' : '' }}>Nuwara Eliya</option>
                    <option value="Galle" {{ old('district') == 'Galle' ? 'selected' : '' }}>Galle</option>
                    <option value="Matara" {{ old('district') == 'Matara' ? 'selected' : '' }}>Matara</option>
                    <option value="Hambantota" {{ old('district') == 'Hambantota' ? 'selected' : '' }}>Hambantota</option>
                    <option value="Jaffna" {{ old('district') == 'Jaffna' ? 'selected' : '' }}>Jaffna</option>
                    <option value="Mannar" {{ old('district') == 'Mannar' ? 'selected' : '' }}>Mannar</option>
                    <option value="Vavuniya" {{ old('district') == 'Vavuniya' ? 'selected' : '' }}>Vavuniya</option>
                    <option value="Mullaitivu" {{ old('district') == 'Mullaitivu' ? 'selected' : '' }}>Mullaitivu</option>
                    <option value="Kilinochchi" {{ old('district') == 'Kilinochchi' ? 'selected' : '' }}>Kilinochchi</option>
                    <option value="Batticaloa" {{ old('district') == 'Batticaloa' ? 'selected' : '' }}>Batticaloa</option>
                    <option value="Ampara" {{ old('district') == 'Ampara' ? 'selected' : '' }}>Ampara</option>
                    <option value="Trincomalee" {{ old('district') == 'Trincomalee' ? 'selected' : '' }}>Trincomalee</option>
                    <option value="Kurunegala" {{ old('district') == 'Kurunegala' ? 'selected' : '' }}>Kurunegala</option>
                    <option value="Puttalam" {{ old('district') == 'Puttalam' ? 'selected' : '' }}>Puttalam</option>
                    <option value="Anuradhapura" {{ old('district') == 'Anuradhapura' ? 'selected' : '' }}>Anuradhapura</option>
                    <option value="Polonnaruwa" {{ old('district') == 'Polonnaruwa' ? 'selected' : '' }}>Polonnaruwa</option>
                    <option value="Badulla" {{ old('district') == 'Badulla' ? 'selected' : '' }}>Badulla</option>
                    <option value="Monaragala" {{ old('district') == 'Monaragala' ? 'selected' : '' }}>Monaragala</option>
                    <option value="Ratnapura" {{ old('district') == 'Ratnapura' ? 'selected' : '' }}>Ratnapura</option>
                    <option value="Kegalle" {{ old('district') == 'Kegalle' ? 'selected' : '' }}>Kegalle</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}">
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="mb-3">
                <label for="emergency_name" class="form-label">Emergency Contact Name</label>
                <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="{{ old('emergency_name') }}">
            </div>
            <div class="mb-3">
                <label for="emergency_phone" class="form-label">Emergency Contact Phone</label>
                <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="{{ old('emergency_phone') }}">
            </div>
            <div class="mb-3">
                <label for="id_type" class="form-label">ID Type</label>
                <select class="form-select" id="id_type" name="id_type">
                    <option value="">Select ID Type</option>
                    <option value="NIC" {{ old('id_type') == 'NIC' ? 'selected' : '' }}>NIC</option>
                    <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                    <option value="Driving License" {{ old('id_type') == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_number" class="form-label">ID Number</label>
                <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number') }}">
            </div>
            <div class="mb-3">
                <label for="preferred_language" class="form-label">Preferred Language</label>
                <select class="form-select" id="preferred_language" name="preferred_language">
                    <option value="">Select Language</option>
                    <option value="English" {{ old('preferred_language') == 'English' ? 'selected' : '' }}>English</option>
                    <option value="Tamil" {{ old('preferred_language') == 'Tamil' ? 'selected' : '' }}>Tamil</option>
                    <option value="Sinhala" {{ old('preferred_language') == 'Sinhala' ? 'selected' : '' }}>Sinhala</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="marketing_opt_in" class="form-label">Marketing Opt-In</label>
                <input type="checkbox" class="form-check-input" id="marketing_opt_in" name="marketing_opt_in" value="1" {{ old('marketing_opt_in') ? 'checked' : '' }}>
            </div>
            <div class="mb-3">
                <label for="accept_terms" class="form-label">Accept Terms</label>
                <input type="checkbox" class="form-check-input" id="accept_terms" name="accept_terms" value="1" {{ old('accept_terms') ? 'checked' : '' }}>
            </div>
            <div class="mb-3">
                <label for="is_verified" class="form-label">Verified</label>
                <input type="checkbox" class="form-check-input" id="is_verified" name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
