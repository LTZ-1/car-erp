<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Payment;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales()
    {
        $orders = SalesOrder::with(['car', 'customer', 'payments'])
            ->latest()
            ->get();

        $totalRevenue = SalesOrder::where('status', \App\Enums\OrderStatus::PAID)
            ->sum('total_price');

        $paidCount = SalesOrder::where('status', \App\Enums\OrderStatus::PAID)->count();
        $pendingCount = SalesOrder::where('status', \App\Enums\OrderStatus::PENDING)->count();

        return view('reports.sales', compact(
            'orders',
            'totalRevenue',
            'paidCount',
            'pendingCount'
        ));
    }

    public function index()
    {
        $totalRevenue = Payment::sum('amount');

        $ordersCount = SalesOrder::count();

        $paidOrders = SalesOrder::where('status', \App\Enums\OrderStatus::PAID)->count();

        $paymentsByMethod = Payment::select(
                'payment_method',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('payment_method')
            ->get();

        $topCars = Car::select(
                'brand',
                'model',
                DB::raw('COUNT(sales_orders.id) as sold_count')
            )
            ->join('sales_orders', 'cars.id', '=', 'sales_orders.car_id')
            ->where('sales_orders.status', \App\Enums\OrderStatus::PAID)
            ->groupBy('brand', 'model')
            ->orderByDesc('sold_count')
            ->limit(5)
            ->get();

        return view('reports.index', compact(
            'totalRevenue',
            'ordersCount',
            'paidOrders',
            'paymentsByMethod',
            'topCars'
        ));
    }
}
