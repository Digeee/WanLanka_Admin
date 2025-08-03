<!-- resources/views/admin/auth/verify-otp.blade.php -->
<form method="POST" action="{{ url('admin/verify-otp') }}">
    @csrf
    <input type="text" name="otp_token" placeholder="Enter OTP" required>
    <button type="submit">Verify OTP</button>
</form>

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
