<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Log;

class CartHelper
{
    public static function userAddProduct(Product $product, $user)
    {
        CartProduct::create([
            'cart_id' => $user->cart->id,
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'price' => $product->price,
        ]);
    }

    public static function updateCart($user)
    {
        $user->cart->update([
            'total_quantity' => $user->cart->products->sum('pivot.quantity'),
            'total_price' => $user->cart->products->sum('pivot.price')
        ]);
    }
}
