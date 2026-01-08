@extends('layouts.app')

@section('page_title', 'Sales Dashboard')

@section('content')
    <h1>Sales Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name ?? 'Sales' }}!</p>

    <p><a href="{{ route('notifications') }}">Notifications ({{ auth()->user()->unreadNotifications->count() }})</a></p>

    <div class="dashboard-grid" style="margin-top:20px;">

        <div class="dashboard-card">
            <h3>Total Sales</h3>
            <div class="value">{{ number_format(\App\Models\SalesOrder::where('user_id', auth()->id())->where('status', \App\Enums\OrderStatus::PAID)->sum('total_price'), 2) }}</div>
        </div>

        <div class="dashboard-card">
            <h3>Orders</h3>
            <div class="value">{{ \App\Models\SalesOrder::where('user_id', auth()->id())->count() }}</div>
        </div>

        <div class="dashboard-card">
            <h3>Cars in Stock</h3>
            <div class="value">{{ \App\Models\Car::where('status', 'AVAILABLE')->count() }}</div>
        </div>

        <div class="dashboard-card">
            <h3>Customers</h3>
            <div class="value">{{ \App\Models\Customer::count() }}</div>
        </div>

    </div>

    <hr>

    <ul>
        <li><a href="{{ route('cars.available') }}">Available Cars</a></li>
        <li><a href="{{ route('sales-orders.index') }}">My Sales Orders</a></li>
        <li><a href="{{ route('customers.index') }}">Customers</a></li>
    </ul>

@endsection