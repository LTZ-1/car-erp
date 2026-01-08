<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\SalesOrder;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalCars' => Car::count(),
            'availableCars' => Car::where('status', 'AVAILABLE')->count(),
            'reservedCars' => Car::where('status', 'RESERVED')->count(),
            'soldCars' => Car::where('status', 'SOLD')->count(),
            'totalRevenue' => SalesOrder::where('status', 'PAID')->sum('total_price'),
        ]);
    }
}
