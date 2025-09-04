@extends('admin.layouts.master')

@section('content')
    <style>
        /* 🌟 Container */
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 20px;
            background: #e0e0e0;
            box-shadow: 9px 9px 16px #bebebe,
                        -9px -9px 16px #ffffff;
        }

        /* 🌟 Headings */
        .container h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }

        .container h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            border-radius: 2px;
            background: #3b7ddd;
            box-shadow: 2px 2px 4px #bebebe,
                        -2px -2px 4px #ffffff;
        }

        /* 🌟 Detail Cards */
        .detail-card {
            padding: 25px;
            border-radius: 18px;
            background: #e0e0e0;
            box-shadow: inset 5px 5px 10px #bebebe,
                        inset -5px -5px 10px #ffffff;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 1.2rem;
            color: #3b7ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #d0d0d0;
            font-weight: 600;
        }

        /* 🌟 Detail Items */
        .detail-item {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .detail-label {
            flex: 0 0 200px;
            font-weight: 600;
            color: #444;
            display: flex;
            align-items: center;
        }

        .detail-label i {
            margin-right: 10px;
            color: #3b7ddd;
            width: 20px;
        }

        .detail-value {
            flex: 1;
            color: #333;
            padding: 10px 15px;
            border-radius: 12px;
            background: #e0e0e0;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            min-height: 40px;
        }

        /* 🌟 Status Badges */
        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            min-width: 100px;
        }

        .status-active {
            background: #198754;
            color: white;
            box-shadow: 2px 2px 5px #bebebe,
                        -2px -2px 5px #ffffff;
        }

        .status-inactive {
            background: #dc3545;
            color: white;
            box-shadow: 2px 2px 5px #bebebe,
                        -2px -2px 5px #ffffff;
        }

        .status-pending {
            background: #ffc107;
            color: black;
            box-shadow: 2px 2px 5px #bebebe,
                        -2px -2px 5px #ffffff;
        }

        /* 🌟 Image Styling */
        .image-container {
            border-radius: 15px;
            padding: 15px;
            background: #e0e0e0;
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            margin-bottom: 20px;
            text-align: center;
        }

        .image-container img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 4px 4px 8px #bebebe,
                        -4px -4px 8px #ffffff;
        }

        .image-placeholder {
            padding: 30px;
            color: #6c757d;
            text-align: center;
        }

        .image-placeholder i {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #a0a0a0;
        }

        /* 🌟 Button Styling */
        .btn-action {
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease;
            margin-right: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-action i {
            margin-right: 8px;
        }

        .btn-edit {
            background: #e0e0e0;
            color: #ffc107;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }

        .btn-edit:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            color: #ffc107;
        }

        .btn-delete {
            background: #e0e0e0;
            color: #dc3545;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }

        .btn-delete:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            color: #dc3545;
        }

        .btn-back {
            background: #e0e0e0;
            color: #6c757d;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
        }

        .btn-back:hover {
            box-shadow: inset 3px 3px 6px #bebebe,
                        inset -3px -3px 6px #ffffff;
            color: #6c757d;
        }

        /* 🌟 Button Container */
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .button-group {
            display: flex;
        }

        /* 🌟 Responsive */
        @media (max-width: 768px) {
            .detail-item {
                flex-direction: column;
            }

            .detail-label {
                flex: 0 0 100%;
                margin-bottom: 10px;
            }

            .detail-value {
                width: 100%;
            }

            .container {
                padding: 20px;
            }

            .button-container {
                flex-direction: column;
                gap: 15px;
            }

            .button-group {
                justify-content: center;
            }

            .btn-back {
                align-self: center;
            }
        }
    </style>

    <div class="container">
        <h1>Guider Details</h1>

        <div class="detail-card">
            <h3 class="section-title">Personal Information</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-user"></i>Full Name
                        </div>
                        <div class="detail-value">
                            {{ $guider->first_name }} {{ $guider->last_name }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-envelope"></i>Email
                        </div>
                        <div class="detail-value">
                            {{ $guider->email }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-phone"></i>Phone
                        </div>
                        <div class="detail-value">
                            {{ $guider->phone ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-map-marker-alt"></i>Address
                        </div>
                        <div class="detail-value">
                            {{ $guider->address ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-city"></i>City
                        </div>
                        <div class="detail-value">
                            {{ $guider->city ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-id-card"></i>NIC Number
                        </div>
                        <div class="detail-value">
                            {{ $guider->nic_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-star"></i>Status
                        </div>
                        <div class="detail-value">
                            <span class="status-badge status-{{ strtolower($guider->status) }}">
                                {{ $guider->status }}
                            </span>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-clock"></i>Availability
                        </div>
                        <div class="detail-value">
                            @if($guider->availability)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-secondary">Not Available</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <h3 class="section-title">Professional Information</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-language"></i>Languages
                        </div>
                        <div class="detail-value">
                            {{ $guider->languages ? implode(', ', $guider->languages) : 'N/A' }}
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-briefcase"></i>Specializations
                        </div>
                        <div class="detail-value">
                            {{ $guider->specializations ? implode(', ', $guider->specializations) : 'N/A' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-chart-line"></i>Experience
                        </div>
                        <div class="detail-value">
                            {{ $guider->experience_years }} years
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-money-bill-wave"></i>Hourly Rate
                        </div>
                        <div class="detail-value">
                            ${{ $guider->hourly_rate }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-car"></i>Vehicle Types
                </div>
                <div class="detail-value">
                    {{ $guider->vehicle_types ? implode(', ', $guider->vehicle_types) : 'N/A' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-file-alt"></i>Description
                </div>
                <div class="detail-value">
                    {{ $guider->description ?? 'No description provided.' }}
                </div>
            </div>
        </div>

        <div class="detail-card">
            <h3 class="section-title">Documents & Images</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="image-container">
                        <h5>Profile Image</h5>
                        @if ($guider->image && Storage::exists($guider->image))
                            <img src="{{ Storage::url($guider->image) }}" alt="Guider Image" class="img-fluid">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-image"></i>
                                <p>No image available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="image-container">
                        <h5>Driving License Photo</h5>
                        @if ($guider->driving_license_photo && Storage::exists($guider->driving_license_photo))
                            <img src="{{ Storage::url($guider->driving_license_photo) }}" alt="Driving License Photo" class="img-fluid">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-id-card"></i>
                                <p>No driving license photo available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Corrected Button Layout -->
        <div class="button-container">
            <div class="button-group">
                <a href="{{ route('admin.guiders.edit', $guider) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i>Edit
                </a>

                <form action="{{ route('admin.guiders.destroy', $guider) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this guider?')">
                        <i class="fas fa-trash"></i>Delete
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.guiders.index') }}" class="btn-action btn-back">
                <i class="fas fa-arrow-left"></i>Back to List
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
