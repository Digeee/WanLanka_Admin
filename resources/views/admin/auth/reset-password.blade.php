<!-- resources/views/admin/auth/reset-password.blade.php -->
@if (session('status'))
    <div>{{ session('status') }}</div>
@endif

<form method="POST" action="{{ url('admin/reset-password') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="otp_token" value="{{ $otp_token }}"> <!-- Ensure OTP token is included -->
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Reset Password</button>
</form>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
