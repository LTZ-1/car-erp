<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(SalesOrder $order)
    {
        if ($order->status !== 'PAID') {
            abort(403, 'Invoice available only for paid orders');
        }

        $order->load(['customer', 'car', 'payments']);

        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            abort(500, 'PDF library not installed. Run: composer require barryvdh/laravel-dompdf');
        }

        $pdf = Pdf::loadView('invoices.invoice', [
            'order' => $order,
            'customer' => $order->customer,
            'car' => $order->car,
            'payments' => $order->payments,
        ]);

        return $pdf->stream('invoice-' . $order->order_number . '.pdf');
    }
}
