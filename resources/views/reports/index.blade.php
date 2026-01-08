@extends('layouts.app')

@section('page_title', 'Management Reports')

@section('content')
<main class="erp-content">

<div class="erp-card">
    <h3>Total Revenue</h3>
    <p>{{ number_format($totalRevenue, 2) }}</p>
</div>

<div class="erp-card">
    <h3>Orders Summary</h3>
    <table class="erp-table">
        <thead>
            <tr><th>Metric</th><th>Value</th></tr>
        </thead>
        <tbody>
            <tr><td>Total Orders</td><td>{{ $ordersCount }}</td></tr>
            <tr><td>Paid Orders</td><td>{{ $paidOrders }}</td></tr>
        </tbody>
    </table>
</div>

<div class="erp-card">
    <h3>Payments by Method</h3>
    <table class="erp-table">
        <thead><tr><th>Method</th><th>Total</th></tr></thead>
        <tbody>
        @foreach($paymentsByMethod as $p)
            <tr><td>{{ $p->payment_method }}</td><td>{{ number_format($p->total, 2) }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="erp-card">
    <h3>Top Selling Cars</h3>
    <table class="erp-table">
        <thead><tr><th>Car</th><th>Sold</th></tr></thead>
        <tbody>
        @foreach($topCars as $car)
            <tr><td>{{ $car->brand }} {{ $car->model }}</td><td>{{ $car->sold_count }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>

</main>
@endsection