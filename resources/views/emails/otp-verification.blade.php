<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4299e1;
            padding: 20px;
            text-align: center;
        }
        .company-name {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .content {
            padding: 30px;
        }
        .otp-container {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #2d3748;
            margin: 15px 0;
            padding: 10px;
            background: #ffffff;
            border-radius: 6px;
            display: inline-block;
            border: 1px dashed #cbd5e0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #718096;
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
        }
        .note {
            font-size: 14px;
            color: #718096;
            margin-top: 25px;
        }
        h1 {
            color: #2d3748;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <!-- Text-based logo instead of image -->
            <h1 class="company-name">WANLANKA</h1>
        </div>

        <div class="content">
            <h1>OTP Verification</h1>
            <p>Hello,</p>
            <p>You're receiving this email because you requested a one-time password (OTP) for your account.</p>

            <div class="otp-container">
                <p>Your verification code is:</p>
                <div class="otp-code">{{ $otp_token }}</div>
                <p>Please enter this code to complete your verification.</p>
            </div>

            <p class="note">
                <strong>Note:</strong> This OTP will expire in 10 minutes. Please do not share this code with anyone.
            </p>

            <p>If you didn't request this OTP, please ignore this email or contact our support team.</p>

            <p>Best regards,<br>The WanLanka Team</p>
        </div>

        <div class="footer">
            <p>© 2023 WanLanka. All rights reserved.</p>
            <p>If you have any questions, contact us at <a href="mailto:support@wanlanka.com" style="color: #4299e1; text-decoration: none;">support@wanlanka.com</a></p>
        </div>
    </div>
</body>
</html>
