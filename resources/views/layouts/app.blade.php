<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Sales ERP</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="erp-layout">

    <!-- Sidebar -->
    <aside class="erp-sidebar">
        <h1>Car ERP</h1>

        <nav>
            <a href="/cars" class="{{ request()->is('cars*') ? 'active' : '' }}">Cars</a>
            <a href="/customers" class="{{ request()->is('customers*') ? 'active' : '' }}">Customers</a>
            <a href="/sales-orders" class="{{ request()->is('sales-orders*') ? 'active' : '' }}">Sales Orders</a>

            <hr style="margin:20px 0; border-color:#374151;">

            {{-- Reports: optional admin-only visual --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="/reports" class="{{ request()->is('reports*') ? 'active' : '' }}">Reports</a>
            @else
                <a href="/reports" class="{{ request()->is('reports*') ? 'active' : '' }}">Reports</a>
            @endif
        </nav>
    </aside>

    <!-- Main -->
    <main class="erp-main">

        <header class="erp-header">
            <h2 class="page-title">@yield('page_title', 'Dashboard')</h2>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>