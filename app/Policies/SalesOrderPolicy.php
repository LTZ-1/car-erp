<?php

namespace App\Policies;

use App\Models\SalesOrder;
use App\Models\User;

class SalesOrderPolicy
{
    public function update(User $user, SalesOrder $order)
    {
        return ($user->role && $user->role->name === 'admin') || $user->id === $order->user_id;
    }
}
