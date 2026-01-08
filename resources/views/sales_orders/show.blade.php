@extends('layouts.app')

@section('content')

<h2>Sales Order {{ $order->order_number }}</h2>

<p>Car: {{ $order->car->brand }} {{ $order->car->model }}</p>
<p>Customer: {{ $order->customer->full_name }}</p>
<p>Status: {{ $order->status }}</p>

<h3>Documents</h3>

@if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
@endif

<ul>
@foreach($order->documents as $doc)
    <li>
        {{ ucfirst($doc->type) }} —
        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">View</a>
    </li>
@endforeach
</ul>

@can('update', $order)
<div class="erp-card">
    <form method="POST" enctype="multipart/form-data" action="{{ route('documents.store', $order) }}" class="erp-form">
        @csrf

        <label>Document Type</label>
        <select name="type" required>
            <option value="contract">Contract</option>
            <option value="id">Customer ID</option>
            <option value="receipt">Receipt</option>
        </select>

        <label>File</label>
        <input type="file" name="document" required>

        <div style="display:flex; gap:8px;">
            <button type="submit" class="btn-primary">Upload</button>
            <a href="{{ route('sales-orders.show', $order) }}" class="btn-secondary">Back</a>
        </div>
    </form>
</div>
@endcan

@endsection
