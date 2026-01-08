@extends('layouts.app')

@section('content')

<h2>Sales Report</h2>

<p>Total Revenue: {{ $totalRevenue }}</p>
<p>Paid Orders: {{ $paidCount }}</p>
<p>Pending Orders: {{ $pendingCount }}</p>

<hr>

@foreach($orders as $order)
<p>
    {{ $order->order_number }} |
    {{ $order->customer->full_name }} |
    {{ $order->car->brand }} {{ $order->car->model }} |
    {{ $order->status }} |
    Paid: {{ $order->payments->sum('amount') }}
</p>
@endforeach

@endsection
