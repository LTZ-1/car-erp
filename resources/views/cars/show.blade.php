@extends('layouts.app')

@section('page_title', 'Car Details')

@section('content')
<main class="erp-content">

    <a href="{{ route('cars.index') }}" class="link-primary">← Back to list</a>

    <div class="erp-card" style="margin-top:12px;">
        <img
            src="{{ asset('images/cars/default-car.jpg') }}"
            alt="Car Image"
            style="width:100%; max-width:400px; border-radius:10px; margin-bottom:20px;"
        >

        <h2>{{ $car->brand ?? 'Brand' }} {{ $car->model ?? '' }}</h2>
        <p class="text-muted">Year: {{ $car->year ?? '-' }} · VIN: {{ $car->vin ?? '-' }}</p>

        <hr style="margin:18px 0;" />

        <div>
            <strong>Price:</strong> {{ $car->selling_price ?? '-' }}
        </div>

        <div style="margin-top:12px;">
            <strong>Status:</strong>
            <span class="status status-{{ strtolower($car->status ?? 'unknown') }}">{{ $car->status ?? 'Unknown' }}</span>
        </div>
    </div>

</main>
@endsection
