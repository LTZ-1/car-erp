@extends('layouts.app')

@section('content')

<div class="erp-card">
    <form method="POST" action="{{ route('cars.update', $car) }}" class="erp-form">
        @csrf @method('PUT')

        <label>Brand</label>
        <input name="brand" value="{{ $car->brand }}">

        <label>Model</label>
        <input name="model" value="{{ $car->model }}">

        <label>Year</label>
        <input name="year" value="{{ $car->year }}">

        <label>VIN</label>
        <input name="vin" value="{{ $car->vin }}">

        <label>Color</label>
        <input name="color" value="{{ $car->color }}">

        <label>Selling Price</label>
        <input name="selling_price" value="{{ $car->selling_price }}">

        <label>Status</label>
        <select name="status">
            <option {{ $car->status=='AVAILABLE'?'selected':'' }}>AVAILABLE</option>
            <option {{ $car->status=='RESERVED'?'selected':'' }}>RESERVED</option>
            <option {{ $car->status=='SOLD'?'selected':'' }}>SOLD</option>
        </select>

        <div style="display:flex; gap:8px;">
            <button class="btn-primary">Update</button>
            <a href="{{ route('cars.index') }}" class="btn-secondary">Back</a>
        </div>
    </form>
</div>

@endsection