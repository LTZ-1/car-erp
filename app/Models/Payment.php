<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\SalesOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_id',
        'amount',
        'payment_method',
        'payment_date'
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    protected static function booted()
    {
        // Prevent overpayment at the model level
        static::creating(function (Payment $payment) {
            $order = SalesOrder::find($payment->sales_order_id);
            if (!$order) {
                throw new \Exception('Sales order not found');
            }

            $totalPaid = $order->payments()->sum('amount');
            $remaining = $order->total_price - $totalPaid;

            if ($payment->amount > $remaining) {
                throw new \Exception('Payment exceeds remaining balance');
            }
        });

        // After creating a payment, update order and car status if fully paid
        static::created(function (Payment $payment) {
            $order = $payment->salesOrder()->first();
            $newTotalPaid = $order->payments()->sum('amount');

            if ($newTotalPaid >= $order->total_price) {
                $order->update(['status' => \App\Enums\OrderStatus::PAID]);
                $order->car->update(['status' => \App\Enums\CarStatus::SOLD]);
            }
        });
    }
}
