<!DOCTYPE html>
<html>
<head>
    <title>Booking Update - WanLanka</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.06);
            border: 1px solid #e2e8f0;
        }

        [data-theme="dark"] .email-container {
            background: #0f172a;
            border: 1px solid #1f2937;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.35);
        }

        .email-header {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .email-body {
            padding: 30px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px) saturate(180%);
            -webkit-backdrop-filter: blur(10px) saturate(180%);
        }

        [data-theme="dark"] .email-body {
            background: rgba(15, 23, 42, 0.6);
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #0f172a;
            font-weight: 600;
        }

        [data-theme="dark"] .greeting {
            color: #e5e7eb;
        }

        .message {
            font-size: 16px;
            margin-bottom: 25px;
            color: #475569;
        }

        [data-theme="dark"] .message {
            color: #cbd5e1;
        }

        .details-container {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            backdrop-filter: blur(8px) saturate(180%);
            -webkit-backdrop-filter: blur(8px) saturate(180%);
        }

        [data-theme="dark"] .details-container {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid #1f2937;
        }

        .details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .details-list li {
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
        }

        [data-theme="dark"] .details-list li {
            border-bottom: 1px solid #1f2937;
        }

        .details-list li:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 700;
            color: #64748b;
            min-width: 120px;
            font-size: 14px;
        }

        [data-theme="dark"] .detail-label {
            color: #94a3b8;
        }

        .detail-value {
            flex: 1;
            color: #0f172a;
            font-weight: 500;
        }

        [data-theme="dark"] .detail-value {
            color: #e5e7eb;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
            margin: 20px 0;
        }

        .status.confirmed {
            background: rgba(34, 197, 94, 0.15);
            color: #166534;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status.pending {
            background: rgba(245, 158, 11, 0.15);
            color: #92400e;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .status.cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: #7f1d1d;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        [data-theme="dark"] .status.confirmed {
            background: rgba(34, 197, 94, 0.2);
            color: #bbf7d0;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        [data-theme="dark"] .status.pending {
            background: rgba(245, 158, 11, 0.2);
            color: #fde68a;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        [data-theme="dark"] .status.cancelled {
            background: rgba(239, 68, 68, 0.2);
            color: #fecaca;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #64748b;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px) saturate(180%);
            -webkit-backdrop-filter: blur(8px) saturate(180%);
        }

        [data-theme="dark"] .footer {
            background: rgba(15, 23, 42, 0.4);
            border-top: 1px solid #1f2937;
            color: #94a3b8;
        }

        .signature {
            font-weight: 600;
            color: #3b82f6;
            margin-top: 10px;
        }

        [data-theme="dark"] .signature {
            color: #60a5fa;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
            }

            .email-body {
                padding: 20px;
            }

            .detail-label {
                min-width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Booking #{{ $booking->id }} {{ ucfirst($type) }} Update</h1>
        </div>

        <div class="email-body">
            <p class="greeting">
                @if($type == 'user')
                    Dear {{ $booking->full_name ?? 'Customer' }},
                @elseif($type == 'guider' && $guider)
                    Dear {{ $guider->first_name ?? 'Guider' }} {{ $guider->last_name ?? '' }},
                @elseif($type == 'unassigned' && $guider)
                    Dear {{ $guider->first_name ?? 'Former Guider' }} {{ $guider->last_name ?? '' }},
                @else
                    Dear Team,
                @endif
            </p>

            <p class="message">
                @if($type == 'unassigned')
                    This booking has been unassigned from you. Details:
                @else
                    Your booking has been assigned/updated:
                @endif
            </p>

            <div class="details-container">
                <ul class="details-list">
                    <li>
                        <span class="detail-label">Date/Time:</span>
                        <span class="detail-value">{{ $booking->date }} at {{ $booking->time }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Pickup:</span>
                        <span class="detail-value">{{ $booking->pickup_location }}, {{ $booking->pickup_district }}</span>
                    </li>
                    <li>
                        <span class="detail-label">People:</span>
                        <span class="detail-value">{{ $booking->people_count }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Vehicle:</span>
                        <span class="detail-value">{{ $vehicle->vehicle_type ?? 'Not assigned yet' }} ({{ $vehicle->number_plate ?? 'N/A' }})</span>
                    </li>
                    @if($guider && $type != 'unassigned' && is_object($guider))
                        <li>
                            <span class="detail-label">Guider:</span>
                            <span class="detail-value">{{ $guider->first_name ?? '' }} {{ $guider->last_name ?? '' }} (Specializations: {{ !empty($guider->specializations) && is_array($guider->specializations) ? implode(', ', $guider->specializations) : 'None' }})</span>
                        </li>
                    @endif
                    <li>
                        <span class="detail-label">Total Price:</span>
                        <span class="detail-value">${{ number_format($booking->total_price, 2) }}</span>
                    </li>
                </ul>
            </div>

            <p>
                <span class="detail-label">Status:</span>
                <span class="status {{ $booking->status }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </p>
        </div>

        <div class="footer">
            <p>Thank you for using our service!</p>
            <p class="signature">- The WanLanka Team</p>
        </div>
    </div>
</body>
</html>
