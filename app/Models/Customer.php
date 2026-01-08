<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'address'
    ];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
