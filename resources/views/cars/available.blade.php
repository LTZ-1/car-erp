@extends('layouts.app')

@section('content')

<h2>Available Cars</h2>

@foreach($cars as $car)
<p>
    {{ $car->brand }} {{ $car->model }} - {{ $car->selling_price }}
</p>
@endforeach

@endsection