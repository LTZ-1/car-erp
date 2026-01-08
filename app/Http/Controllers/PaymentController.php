<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Services\AuditLogger;

class PaymentController extends Controller
{
    public function create(SalesOrder $order)
    {
        // Prevent creating a payment for a fully paid order
        if ($order->status === \App\Enums\OrderStatus::PAID) {
            return back()->withErrors('Order already fully paid');
        }

        $totalPaid = $order->payments()->sum('amount');
        $remaining = $order->total_price - $totalPaid;

        return view('payments.create', compact('order', 'totalPaid', 'remaining'));
    }

    public function store(Request $request, SalesOrder $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required',
            'payment_date' => 'required|date',
        ]);

        // Authorization via policy
        $this->authorize('update', $order);

        // No payments for already paid orders
        if ($order->status === \App\Enums\OrderStatus::PAID) {
            abort(403, 'Order already fully paid');
        }

        $result = DB::transaction(function () use ($request, $order) {

            // Lock the order row to prevent race conditions
            $order = SalesOrder::lockForUpdate()->findOrFail($order->id);

            $totalPaid = $order->payments()->sum('amount');
            $remaining = $order->total_price - $totalPaid;

            if ($request->amount > $remaining) {
                throw new \Exception('Overpayment not allowed');
            }

            $payment = Payment::create([
                'sales_order_id' => $order->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
            ]);

            // Audit log for payment
            AuditLogger::log(
                'RECORD_PAYMENT',
                $order,
                'Payment of ' . $request->amount . ' recorded'
            );

            $newTotalPaid = $order->payments()->sum('amount');

            $paidNow = false;
            if ($newTotalPaid >= $order->total_price) {
                $order->update(['status' => \App\Enums\OrderStatus::PAID]);
                $order->car->update(['status' => \App\Enums\CarStatus::SOLD]);

                // Audit car sold
                AuditLogger::log(
                    'CAR_SOLD',
                    $order->car,
                    'Car sold via order ' . $order->order_number
                );

                $paidNow = true;
            }

            return ['payment' => $payment, 'order' => $order, 'paidNow' => $paidNow];

        });

        // Notify user about payment
        if (class_exists(\App\Notifications\PaymentRecorded::class)) {
            auth()->user()->notify(new \App\Notifications\PaymentRecorded($result['order']));
        }

        // If fully paid, notify order-paid
        if ($result['paidNow'] && class_exists(\App\Notifications\OrderPaid::class)) {
            auth()->user()->notify(new \App\Notifications\OrderPaid($result['order']));
        }

        return redirect()->route('sales-orders.index')
            ->with('success', 'Payment processed safely');
    }
}
