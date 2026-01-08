@extends('layouts.app')

@section('page_title', 'Audit Logs')

@section('content')
<main class="erp-content">

@if($logs->count() === 0)
    <p class="text-muted">No audit logs available.</p>
@else
<div class="erp-card">
    <table class="erp-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Action</th>
                <th>Entity</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->user->name }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ class_basename($log->entity_type) }} #{{ $log->entity_id }}</td>
                <td>{{ $log->description }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

</main>
@endsection
