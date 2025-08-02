<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - WanLanka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7fafc;
        }
        .login-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
        }
        .form-container {
            width: 45%;
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }
        .form-container p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #48bb78;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container button:hover {
            background-color: #38a169;
        }
        .image-container {
            width: 50%;
            position: relative;
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }
        .forgot-password {
            color: #3182ce;
            text-decoration: underline;
            cursor: pointer;
        }
        .forgot-password:hover {
            color: #2b6cb0;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Left: Login Form -->
        <div class="form-container">
            <h2>Welcome back Admin!</h2>
            <p>Enter your Credentials to access your account</p>

            <form method="POST" action="{{ url('admin/login') }}">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <button type="submit">Login</button>

                @if ($errors->any())
                    <ul class="text-red-500 mt-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>

            <p class="mt-4 text-center">
                <a href="{{ route('admin.forgot-password') }}" class="forgot-password">Forgot Password?</a>
            </p>
        </div>

        <!-- Right: Image -->
        <div class="image-container">
            <img src="{{ asset('images/wanlanka-login.png') }}" alt="WanLanka">
        </div>
    </div>

</body>
</html>
