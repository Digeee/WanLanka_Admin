<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - WanLanka</title>
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
            text-align: center;
            letter-spacing: 0.5rem;
            font-weight: bold;
        }

        .neumorphic-input:focus {
            outline: none;
            box-shadow:
                inset 4px 4px 8px #c9ccd3,
                inset -4px -4px 8px #ffffff;
        }

        .neumorphic-input::placeholder {
            color: #a0aec0;
            letter-spacing: normal;
            font-weight: normal;
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
        <!-- OTP Form -->
        <div class="neumorphic-card">
            <h2>🔐 OTP Verification</h2>
            <p>We've sent a 6-digit code to your email. Please enter it below to verify your identity.</p>

            <form method="POST" action="{{ url('admin/verify-otp') }}">
                @csrf
                <input type="text" name="otp_token" placeholder="Enter OTP" required
                       maxlength="6" pattern="\d{6}" title="Please enter exactly 6 digits"
                       class="neumorphic-input">
                <button type="submit" class="neumorphic-button">✅ Verify OTP</button>

                @if (session('status'))
                    <div class="status-message">
                        ℹ️ {{ session('status') }}
                    </div>
                @endif

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
            <img src="{{ asset('images/wanlanka-login.png') }}" alt="WanLanka OTP Verification">
        </div>
    </div>

    <script>
        // Auto-advance between OTP digits
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.querySelector('input[name="otp_token"]');

            otpInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            otpInput.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0) {
                    this.previousElementSibling?.focus();
                }
            });
        });
    </script>
</body>
</html>
