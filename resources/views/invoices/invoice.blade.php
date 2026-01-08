<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:8px; }
    </style>
</head>
<body>

<div class="header">
    <h2>CAR SALES INVOICE</h2>
    <p>Invoice #: {{ $order->order_number }}</p>
</div>

<div class="section">
    <strong>Customer:</strong><br>
    {{ $customer->full_name }}<br>
    {{ $customer->phone }}<br>
    {{ $customer->email }}
</div>

<div class="section">
    <strong>Car Details:</strong>
    <table>
        <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Year</th>
            <th>VIN</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>{{ $car->brand }}</td>
            <td>{{ $car->model }}</td>
            <td>{{ $car->year }}</td>
            <td>{{ $car->vin }}</td>
            <td>{{ $order->total_price }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <strong>Payments:</strong>
    <table>
        <tr>
            <th>Date</th>
            <th>Method</th>
            <th>Amount</th>
        </tr>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->payment_date }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td>{{ $payment->amount }}</td>
        </tr>
        @endforeach
    </table>
</div>

<h3>Total Paid: {{ $payments->sum('amount') }}</h3>

<p><strong>Status:</strong> {{ $order->status }}</p>

</body>
</html>