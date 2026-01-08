<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\AuditLogger;

class SalesOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = SalesOrder::with(['customer','car']);

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('sales_orders.index', compact('orders'));
    }

    public function create()
    {
        $cars = Car::where('status', 'AVAILABLE')->get();
        $customers = Customer::all();

        return view('sales_orders.create', compact('cars', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $order = DB::transaction(function () use ($request) {

            // Lock the car row to avoid race conditions
            $car = Car::lockForUpdate()->findOrFail($request->car_id);

            if ($car->status !== \App\Enums\CarStatus::AVAILABLE) {
                throw new \Exception('Car not available');
            }

            // Ensure no other pending order exists for this car
            $existing = SalesOrder::where('car_id', $car->id)
                ->where('status', \App\Enums\OrderStatus::PENDING)
                ->exists();

            if ($existing) {
                throw new \Exception('This car already has an active sales order');
            }

            // Unique human-readable order number
            do {
                $orderNumber = 'SO-' . strtoupper(Str::random(8));
            } while (SalesOrder::where('order_number', $orderNumber)->exists());

            $order = SalesOrder::create([
                'order_number' => $orderNumber,
                'car_id' => $car->id,
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'total_price' => $car->selling_price,
                'status' => \App\Enums\OrderStatus::PENDING,
            ]);

            // Reserve the car
            $car->update(['status' => \App\Enums\CarStatus::RESERVED]);

            // Audit log
            AuditLogger::log(
                'CREATE_SALES_ORDER',
                $order,
                'Sales order created and car reserved'
            );

            return $order;
        });

        // Notify the creator
        if (class_exists(\App\Notifications\SalesOrderCreated::class)) {
            auth()->user()->notify(new \App\Notifications\SalesOrderCreated($order));
        }

        return redirect()->route('sales-orders.index')
            ->with('success', 'Sales order created safely');
    }
}
