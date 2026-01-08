@extends('layouts.app')

@section('content')

<h2>Customers</h2>
<a href="{{ route('customers.create') }}">Add Customer</a>

<form method="GET" class="erp-form" style="margin-top:8px; margin-bottom:12px;">
    <label>Search</label>
    <input type="text" name="search" placeholder="Search name or phone" value="{{ request('search') }}">
    <button type="submit" class="btn-secondary">Search</button>
</form>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="erp-card">
    <table class="erp-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->full_name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn-secondary">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{ $customers->appends(request()->except('page'))->links() }}

@endsection