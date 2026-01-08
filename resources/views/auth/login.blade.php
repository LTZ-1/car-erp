@extends('layouts.app')

@section('page_title', 'Login')

@section('content')
<main class="erp-content">

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="/login" class="erp-form">
    @csrf
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required />

    <label>Password</label>
    <input type="password" name="password" required />

    <div style="display:flex; gap:8px;">
        <button type="submit" class="btn-primary">Login</button>
        <a href="/register" class="btn-secondary">Register</a>
    </div>
</form>

</main>
@endsection