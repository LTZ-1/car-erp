<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('register', [\App\Http\Controllers\AuthController::class, 'showRegister']);
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', fn() => redirect()->route('admin.dashboard'));

        // Admin dashboard (KPIs)
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Admin - full car management
        Route::resource('cars', \App\Http\Controllers\CarController::class);

        // Reports (Admin only)
        Route::get('/reports/sales', [ReportController::class, 'sales'])
            ->name('reports.sales');

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        // CSV export (admin only)
        Route::get('/export/sales-orders', function () {
            return response()->streamDownload(function () {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Order #','Customer','Car','Total','Status']);

                \App\Models\SalesOrder::with(['customer','car'])->chunk(100, function ($orders) use ($handle) {
                    foreach ($orders as $order) {
                        fputcsv($handle, [
                            $order->order_number,
                            $order->customer->full_name,
                            $order->car->brand . ' ' . $order->car->model,
                            $order->total_price,
                            $order->status
                        ]);
                    }
                });

                fclose($handle);
            }, 'sales_orders.csv');
        })->name('export.sales-orders');

        // Audit logs (Admin only)
        Route::get('/admin/audit-logs', function () {
            $logs = \App\Models\AuditLog::with('user')->latest()->get();
            return view('admin.audit_logs', compact('logs'));
        })->name('audit.logs');
    });

    Route::middleware(['role:sales'])->group(function () {
        Route::get('/sales', fn() => redirect()->route('sales.dashboard'));

        // Sales dashboard
        Route::get('/sales/dashboard', fn() => view('sales.dashboard'))->name('sales.dashboard');

        // Sales - view available cars only
        Route::get('/available-cars', [\App\Http\Controllers\CarController::class, 'available'])
            ->name('cars.available');

        // Sales - customer management (index / create / store)
        Route::resource('customers', \App\Http\Controllers\CustomerController::class)->only([
            'index','create','store'
        ]);

        // Sales - sales order creation & listing
        Route::get('/sales-orders/create', [\App\Http\Controllers\SalesOrderController::class, 'create'])
            ->name('sales-orders.create');

        Route::post('/sales-orders', [\App\Http\Controllers\SalesOrderController::class, 'store'])
            ->name('sales-orders.store');

        Route::get('/sales-orders', [\App\Http\Controllers\SalesOrderController::class, 'index'])
            ->name('sales-orders.index');

        Route::get('/sales-orders/create', [\App\Http\Controllers\SalesOrderController::class, 'create'])
            ->name('sales-orders.create');

        Route::post('/sales-orders', [\App\Http\Controllers\SalesOrderController::class, 'store'])
            ->name('sales-orders.store');

        // Payments for sales orders
        Route::get('/sales-orders/{order}/payments/create', [\App\Http\Controllers\PaymentController::class, 'create'])
            ->name('payments.create');

        Route::post('/sales-orders/{order}/payments', [\App\Http\Controllers\PaymentController::class, 'store'])
            ->name('payments.store');

    });

    // Allow authenticated users to view a single order (owner or admin will be authorized in controller)
    Route::get('/sales-orders/{order}', [\App\Http\Controllers\SalesOrderController::class, 'show'])
        ->name('sales-orders.show');

    // Documents upload (authenticated users)
    Route::post('/sales-orders/{order}/documents', [\App\Http\Controllers\DocumentController::class, 'store'])
        ->name('documents.store');

    // Invoice viewing for any authenticated user (admin & sales)
    Route::get('/sales-orders/{order}/invoice', [InvoiceController::class, 'show'])
        ->name('invoice.show');

    // Notifications (authenticated users)
    Route::get('/notifications', function () {
        $user = auth()->user();
        if (!$user) {
            abort(403);
        }

        // mark as read when opening
        $user->unreadNotifications->markAsRead();

        $notifications = $user->notifications()->latest()->get();

        return view('notifications.index', compact('notifications'));
    })->name('notifications');

});
