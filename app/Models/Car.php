<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'brand',
        'model',
        'year',
        'vin',
        'color',
        'selling_price',
        'status'
    ];

    public function salesOrder()
    {
        return $this->hasOne(SalesOrder::class);
    }
}
