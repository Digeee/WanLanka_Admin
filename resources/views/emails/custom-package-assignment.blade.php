<!DOCTYPE html>
<html>
<head>
    <title>Custom Package Assignment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2d3748;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .package-details {
            background-color: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #4a5568;
        }
        .detail-value {
            flex: 1;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #718096;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #3182ce;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .status-approved {
            color: #38a169;
            font-weight: bold;
        }
        .status-pending {
            color: #d69e2e;
            font-weight: bold;
        }
        .status-rejected {
            color: #e53e3e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>WanLanka Custom Package</h1>
    </div>
    
    <div class="content">
        <h2>Hello {{ $type === 'user' ? $user->name : $guider->first_name . ' ' . $guider->last_name }},</h2>
        
        @if($type === 'user')
            <p>Your custom travel package has been updated with the following details:</p>
        @else
            <p>You have been assigned to a custom travel package. Please review the details below:</p>
        @endif
        
        <div class="package-details">
            <h3>Package Details</h3>
            
            <div class="detail-row">
                <div class="detail-label">Package Title:</div>
                <div class="detail-value">{{ $customPackage->title }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    <span class="status-{{ $customPackage->status }}">
                        {{ ucfirst($customPackage->status) }}
                    </span>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Start Location:</div>
                <div class="detail-value">{{ $customPackage->start_location }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Duration:</div>
                <div class="detail-value">{{ $customPackage->duration }} days</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Number of People:</div>
                <div class="detail-value">{{ $customPackage->num_people }}</div>
            </div>
            
            @if($customPackage->travel_date)
            <div class="detail-row">
                <div class="detail-label">Travel Date:</div>
                <div class="detail-value">{{ $customPackage->travel_date->format('F j, Y') }}</div>
            </div>
            @endif
            
            @if($customPackage->price)
            <div class="detail-row">
                <div class="detail-label">Price:</div>
                <div class="detail-value">LKR {{ number_format($customPackage->price, 2) }}</div>
            </div>
            @endif
            
            @if($customPackage->guider_name)
            <div class="detail-row">
                <div class="detail-label">Assigned Guider:</div>
                <div class="detail-value">{{ $customPackage->guider_name }}</div>
            </div>
            @endif
        </div>
        
        @if($type === 'user' && $customPackage->guider_name)
            <p>Your package has been assigned to <strong>{{ $customPackage->guider_name }}</strong>. They will contact you soon to discuss the details.</p>
        @elseif($type === 'guider')
            <p>You have been assigned to this package. Please contact the user to discuss the details.</p>
            <p>User Contact: {{ $user->name }} ({{ $user->email }})</p>
        @endif
        
        @if($customPackage->status === 'approved')
            <p class="status-approved">Your package has been approved! You can now proceed with the booking.</p>
        @elseif($customPackage->status === 'rejected')
            <p class="status-rejected">Unfortunately, your package has been rejected. Please contact us for more information.</p>
        @endif
        
        <div style="text-align: center;">
            <a href="#" class="button">View Package Details</a>
        </div>
        
        <p>If you have any questions, please don't hesitate to contact our support team.</p>
        
        <p>Best regards,<br>The WanLanka Team</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} WanLanka. All rights reserved.</p>
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>