<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - WanLanka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6e9f0;
            color: #4a5568;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            gap: 2rem;
        }

        .neumorphic-card {
            background: #e6e9f0;
            border-radius: 1.5rem;
            box-shadow:
                12px 12px 24px #c9ccd3,
                -12px -12px 24px #ffffff;
            padding: 2.5rem;
            width: 50%;
            transition: all 0.3s ease;
        }

        .neumorphic-card:hover {
            box-shadow:
                15px 15px 30px #c9ccd3,
                -15px -15px 30px #ffffff;
        }

        .neumorphic-image {
            background: #e6e9f0;
            border-radius: 1.5rem;
            box-shadow:
                12px 12px 24px #c9ccd3,
                -12px -12px 24px #ffffff;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow: hidden;
        }

        .neumorphic-image img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
            object-fit: cover;
            box-shadow:
                8px 8px 16px #c9ccd3,
                -8px -8px 16px #ffffff;
        }

        .neumorphic-input {
            background: #e6e9f0;
            border: none;
            border-radius: 1rem;
            box-shadow:
                inset 6px 6px 12px #c9ccd3,
                inset -6px -6px 12px #ffffff;
            color: #4a5568;
            padding: 1rem 1.25rem;
            width: 100%;
            margin-bottom: 1.75rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .neumorphic-input:focus {
            outline: none;
            box-shadow:
                inset 4px 4px 8px #c9ccd3,
                inset -4px -4px 8px #ffffff;
        }

        .neumorphic-input::placeholder {
            color: #a0aec0;
        }

        .password-strength {
            height: 4px;
            background: #e6e9f0;
            border-radius: 2px;
            margin: -0.75rem 0 1.25rem;
            overflow: hidden;
            box-shadow:
                inset 2px 2px 4px #c9ccd3,
                inset -2px -2px 4px #ffffff;
        }

        .password-strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .neumorphic-button {
            background: linear-gradient(145deg, #f0f3fa, #dce0e7);
            border: none;
            border-radius: 1rem;
            box-shadow:
                8px 8px 16px #c9ccd3,
                -8px -8px 16px #ffffff;
            color: #4a5568;
            padding: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 1rem;
        }

        .neumorphic-button:hover {
            box-shadow:
                4px 4px 8px #c9ccd3,
                -4px -4px 8px #ffffff;
            color: #2d3748;
        }

        .neumorphic-button:active {
            box-shadow:
                inset 6px 6px 12px #c9ccd3,
                inset -6px -6px 12px #ffffff;
        }

        .status-message {
            color: #38a169;
            margin: 1.5rem 0;
            padding: 1rem;
            background: #e6e9f0;
            border-radius: 1rem;
            text-align: center;
            box-shadow:
                inset 4px 4px 8px #c9ccd3,
                inset -4px -4px 8px #ffffff;
        }

        .error-message {
            color: #e53e3e;
            margin: 1.5rem 0;
            padding: 1rem;
            background: #e6e9f0;
            border-radius: 1rem;
            text-align: center;
            box-shadow:
                inset 4px 4px 8px #c9ccd3,
                inset -4px -4px 8px #ffffff;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            color: #2d3748;
        }

        p {
            color: #718096;
            margin-bottom: 2.5rem;
            text-align: center;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .neumorphic-card, .neumorphic-image {
                width: 100%;
            }
            .neumorphic-image {
                margin-top: 2rem;
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Reset Password Form -->
        <div class="neumorphic-card">
            <h2>🔄 Reset Your Password</h2>
            <p>Create a new secure password for your admin account</p>

            @if (session('status'))
                <div class="status-message">
                    ℹ️ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ url('admin/reset-password') }}">
                @csrf
                <input type="password" name="password" placeholder="🔒 New Password" required
                       class="neumorphic-input" id="password">
                <div class="password-strength">
                    <div class="password-strength-fill" id="password-strength-fill"></div>
                </div>

                <input type="password" name="password_confirmation" placeholder="🔏 Confirm Password" required
                       class="neumorphic-input">

                <button type="submit" class="neumorphic-button">🔄 Reset Password</button>

                @if ($errors->any())
                    <ul class="error-message">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
        </div>

        <!-- Image Container -->
        <div class="neumorphic-image">
            <img src="{{ asset('images/wanlanka-login.png') }}" alt="WanLanka Password Reset">
        </div>
    </div>

    <script>
        // Password strength indicator
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthFill = document.getElementById('password-strength-fill');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Length check
                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;

                // Complexity checks
                if (/[A-Z]/.test(password)) strength += 1;
                if (/[0-9]/.test(password)) strength += 1;
                if (/[^A-Za-z0-9]/.test(password)) strength += 1;

                // Update strength meter
                const width = (strength / 5) * 100;
                strengthFill.style.width = `${width}%`;

                // Update color based on strength
                if (width < 40) {
                    strengthFill.style.background = '#e53e3e'; // Red
                } else if (width < 70) {
                    strengthFill.style.background = '#dd6b20'; // Orange
                } else {
                    strengthFill.style.background = '#38a169'; // Green
                }
            });
        });
    </script>
</body>
</html>
