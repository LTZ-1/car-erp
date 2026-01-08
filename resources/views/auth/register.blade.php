@extends('layouts.app')

@section('page_title', 'Register')

@section('content')
<main class="erp-content">

@if($errors->any())
    <div class="alert alert-error">{{ implode(', ', $errors->all()) }}</div>
@endif

<form method="POST" action="/register" class="erp-form">
    @csrf

    <label>Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required />

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required />

    <label>Password</label>
    <input type="password" name="password" required />

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" required />

    <div style="display:flex; gap:8px;">
        <button type="submit" class="btn-primary">Register</button>
        <a href="/login" class="btn-secondary">Back</a>
    </div>
</form>

</main>
@endsection