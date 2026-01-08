@extends('layouts.app')

@section('page_title', 'Notifications')

@section('content')
<main class="erp-content">

<p>Total: {{ $notifications->count() }}</p>

@if($notifications->count() === 0)
    <p class="text-muted">No notifications.</p>
@else
<div class="erp-card">
    <table class="erp-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
        @foreach($notifications as $n)
            <tr>
                <td>{{ $n->created_at }}</td>
                <td>{{ $n->data['message'] ?? 'Notification' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

</main>
@endsection