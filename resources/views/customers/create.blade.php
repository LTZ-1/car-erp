@extends('layouts.app')

@section('content')

<div class="erp-card">
    <form method="POST" action="{{ route('customers.store') }}" class="erp-form">
        @csrf

        <label>Full Name</label>
        <input name="full_name" placeholder="Full Name">

        <label>Phone</label>
        <input name="phone" placeholder="Phone">

        <label>Email</label>
        <input name="email" placeholder="Email">

        <label>Address</label>
        <input name="address" placeholder="Address">

        <div style="display:flex; gap:8px;">
            <button class="btn-primary">Add Customer</button>
            <a href="{{ route('customers.index') }}" class="btn-secondary">Back</a>
        </div>
    </form>
</div>

@endsection