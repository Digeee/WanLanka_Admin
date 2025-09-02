@extends('admin.layouts.master')

@section('title', 'View Guider')
@section('page-title', 'Guider Details')

@section('content')
<div class="content-section">
    <h2>{{ $guider->first_name }} {{ $guider->last_name }}</h2>
    <p>Email: {{ $guider->email }}</p>
    <p>Phone: {{ $guider->phone }}</p>
    <p>Experience: {{ $guider->experience_years }} years</p>
    <p>Rate: ${{ $guider->hourly_rate }}</p>
    <p>Status: {{ ucfirst($guider->status) }}</p>
    @if($guider->image)
        <img src="{{ asset('storage/'.$guider->image) }}" width="150">
    @endif
</div>
@endsection
