@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
<main class="erp-content">

<p>Welcome, {{ auth()->user()->name ?? 'Admin' }}!</p>

<div class="dashboard-grid" style="margin-top:20px;">

    <div class="dashboard-card">
        <h3>Total Sales</h3>
        <div class="value">{{ number_format($totalRevenue ?? 0, 2) }}</div>
    </div>

    <div class="dashboard-card">
        <h3>Orders</h3>
        <div class="value">{{ \App\Models\SalesOrder::count() }}</div>
    </div>

    <div class="dashboard-card">
        <h3>Cars in Stock</h3>
        <div class="value">{{ $availableCars ?? \App\Models\Car::where('status', 'AVAILABLE')->count() }}</div>
    </div>

    <div class="dashboard-card">
        <h3>Customers</h3>
        <div class="value">{{ \App\Models\Customer::count() }}</div>
    </div>

</div>

<p style="margin-top:20px;"><a href="{{ route('reports.sales') }}">View Sales Report</a></p>
<p style="margin-top:10px;"><a href="{{ route('notifications') }}">Notifications</a></p>

</main>
@endsection