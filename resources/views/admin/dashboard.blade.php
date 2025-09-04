@extends('admin.layouts.master')

@section('content')
    <style>
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 20px;
            background: #e0e0e0;
            box-shadow: 9px 9px 16px #bebebe,
                        -9px -9px 16px #ffffff;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }
        .card {
            background: #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 5px 5px 10px #bebebe,
                        -5px -5px 10px #ffffff;
            text-align: center;
        }
        .card h3 {
            margin: 0 0 10px;
            color: #444;
            font-weight: 500;
        }
        .card p {
            font-size: 2rem;
            color: #333;
            margin: 0;
            font-weight: 600;
        }
    </style>

    <div class="container">
        <h1>Admin Dashboard</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h3>Total Guiders</h3>
                    <p>{{ $guiderCount }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h3>Total Vehicles</h3>
                    <p>{{ $vehicleCount }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h3>Total Accommodations</h3>
                    <p>{{ $accommodationCount }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h3>Total Places</h3>
                    <p>{{ $placeCount }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
