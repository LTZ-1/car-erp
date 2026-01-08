@extends('layouts.app')

@section('content')

<h2>Create Sales Order</h2>

<div class="erp-card">
    <form method="POST" action="{{ route('sales-orders.store') }}" class="erp-form">
        @csrf

        <label>Car</label>
        <select name="car_id" required>
            <option value="">Select Car</option>
            @foreach($cars as $car)
                <option value="{{ $car->id }}">
                    {{ $car->brand }} {{ $car->model }} - {{ $car->selling_price }}
                </option>
            @endforeach
        </select>

        <label>Customer</label>
        <select name="customer_id" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">
                    {{ $customer->full_name }} ({{ $customer->phone }})
                </option>
            @endforeach
        </select>

        <div style="display:flex; gap:8px;">
            <button class="btn-primary">Create Order</button>
            <a href="{{ route('sales-orders.index') }}" class="btn-secondary">Back</a>
        </div>
    </form>
</div>

@endsection