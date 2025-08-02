<!-- resources/views/admin/auth/forgot-password.blade.php -->
<form method="POST" action="{{ url('admin/forgot-password') }}">
    @csrf
    <input type="email" name="email" placeholder="Enter Your Email" required>
    <button type="submit">Send Verification Code</button>
</form>

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<a href="{{ url('admin/login') }}">Remember your password? Login instead</a>
