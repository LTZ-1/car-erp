@extends('layouts.app')

@section('page_title', 'Sales Orders')

@section('content')
<main class="erp-content">

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" class="erp-form" style="margin-bottom:12px;">
    <label>Search / Filter</label>
    <input type="text" name="search" placeholder="Order #" value="{{ request('search') }}">

    <select name="status">
        <option value="">All</option>
        <option value="{{ \App\Enums\OrderStatus::PENDING }}" {{ request('status') == \App\Enums\OrderStatus::PENDING ? 'selected' : '' }}>Pending</option>
        <option value="{{ \App\Enums\OrderStatus::PAID }}" {{ request('status') == \App\Enums\OrderStatus::PAID ? 'selected' : '' }}>Paid</option>
    </select>

    <button type="submit" class="btn-secondary">Filter</button>
</form>

@if($orders->count() === 0)
    <p class="text-muted">No sales orders found.</p>
@else
<div class="erp-card">
    <table class="erp-table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Car</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td><a href="{{ route('sales-orders.show', $order) }}">{{ $order->order_number }}</a></td>
                <td>{{ $order->customer->full_name }}</td>
                <td>{{ $order->car->brand }} {{ $order->car->model }}</td>
                <td><span class="status status-{{ strtolower($order->status) }}">{{ $order->status }}</span></td>
                <td>
                    @if($order->status === \App\Enums\OrderStatus::PENDING)
                        <a href="{{ route('payments.create', $order) }}" class="btn-primary">Add Payment</a>
                    @endif

                    @if($order->status === \App\Enums\OrderStatus::PAID)
                        <a href="{{ route('invoice.show', $order) }}" target="_blank" class="btn-secondary">View Invoice</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $orders->appends(request()->except('page'))->links() }}
@endif

</main>
@endsection