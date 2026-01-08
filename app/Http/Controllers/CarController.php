<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Car;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $query->where('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%')
                  ->orWhere('vin', 'like', '%' . $request->search . '%');
        }

        $cars = $query->paginate(15);
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|digits:4',
            'vin' => 'required|unique:cars',
            'color' => 'required',
            'selling_price' => 'required|numeric',
        ]);

        Car::create($request->all());

        return redirect()->route('cars.index')
            ->with('success', 'Car added successfully');
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|digits:4',
            'vin' => 'required|unique:cars,vin,' . $car->id,
            'color' => 'required',
            'selling_price' => 'required|numeric',
            'status' => 'required',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')
            ->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully');
    }

    // Sales view
    public function available()
    {
        $cars = Car::where('status', \App\Enums\CarStatus::AVAILABLE)->get();
        return view('cars.available', compact('cars'));
    }
}
