<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\OrderProduct;


class OrderHelper
{
    public static function create($user)
    {
        return Order::create([
            'user_id' => $user->id,
            'total_quantity' => $user->cart->total_quantity,
            'total_price' => $user->cart->total_price,
        ]);
    }
}
