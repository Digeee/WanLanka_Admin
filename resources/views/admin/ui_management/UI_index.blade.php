@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Slider Management -->
            <div class="col-md-3">
                <div class="card text-center">
                    <i class="fas fa-image fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">Slider Management</h5>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Slider</a>

                </div>
            </div>

            <!-- Footer Management -->
            <div class="col-md-3">
                <div class="card text-center">
                    <i class="fas fa-cogs fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">Footer Management</h5>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Slider</a>

                    </div>
                </div>
            </div>

            <!-- Contact Us Management -->
            <div class="col-md-3">
                <div class="card text-center">
                    <i class="fas fa-address-book fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">Contact Us Management</h5>
                       <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Slider</a>

                    </div>
                </div>
            </div>

            <!-- About Us Management -->
            <div class="col-md-3">
                <div class="card text-center">
                    <i class="fas fa-info-circle fa-3x"></i>
                    <div class="card-body">
                        <h5 class="card-title">About Us Management</h5>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Manage Slider</a>

                    </div>
                </div>
            </div>

            <!-- Add more containers as needed -->
        </div>
    </div>
@endsection
