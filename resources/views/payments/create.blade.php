@extends('layouts.app')

@section('content')

<h2>Record Payment</h2>

<p>Order: {{ $order->order_number }}</p>
<p>Total Price: {{ $order->total_price }}</p>
<p>Total Paid: {{ $totalPaid }}</p>
<p>Remaining: {{ $remaining }}</p>

@if($order->status !== \App\Enums\OrderStatus::PENDING)
    <p>Payments are not allowed for this order (status: {{ $order->status }})</p>
@else
<div class="erp-card">
    <form method="POST" action="{{ route('payments.store', $order) }}" class="erp-form">
        @csrf

        <label>Amount</label>
        <input name="amount" placeholder="Payment Amount" required>

        <label>Payment Method</label>
        <input name="payment_method" placeholder="Cash / Transfer" required>

        <label>Payment Date</label>
        <input type="date" name="payment_date" required>

        <div style="display:flex; gap:8px;">
            <button class="btn-primary">Submit Payment</button>
            <a href="{{ route('sales-orders.show', $order) }}" class="btn-secondary">Back</a>
        </div>
    </form>
</div>
@endif

@endsection