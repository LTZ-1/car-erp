@extends('layouts.app')

@section('content')

<div class="erp-card">
    <form method="POST" action="{{ route('cars.store') }}" class="erp-form">
        @csrf

        <label>Brand</label>
        <input name="brand" placeholder="Brand">

        <label>Model</label>
        <input name="model" placeholder="Model">

        <label>Year</label>
        <input name="year" placeholder="Year">

        <label>VIN</label>
        <input name="vin" placeholder="VIN">

        <label>Color</label>
        <input name="color" placeholder="Color">

        <label>Selling Price</label>
        <input name="selling_price" placeholder="Price">

        <div style="display:flex; gap:8px;">
            <button class="btn-primary">Add</button>
            <a href="{{ route('cars.index') }}" class="btn-secondary">Back</a>
        </div>
    </form>
</div>

@endsection