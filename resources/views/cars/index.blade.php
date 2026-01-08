@extends('layouts.app')

@section('page_title', 'Cars')

@section('content')
<main class="erp-content">

<a href="{{ route('cars.create') }}" class="link-primary">Add Car</a>

<form method="GET" class="erp-form" style="margin-top:8px; margin-bottom:12px;">
    <label>Search</label>
    <input type="text" name="search" placeholder="Brand, model or VIN" value="{{ request('search') }}">
    <button type="submit" class="btn-secondary">Search</button>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($cars->count() === 0)
    <p class="text-muted">No cars found.</p>
@else
<div class="erp-card">
    <table class="erp-table">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>VIN</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cars as $car)
            <tr>
                <td>{{ $car->brand }}</td>
                <td>{{ $car->model }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ $car->vin }}</td>
                <td>{{ $car->selling_price }}</td>
                <td><span class="status status-{{ strtolower($car->status) }}">{{ $car->status }}</span></td>
                <td>
                    <a href="{{ route('cars.edit', $car) }}" class="btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('cars.destroy', $car) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $cars->appends(request()->except('page'))->links() }}
@endif

</main>

@endsection