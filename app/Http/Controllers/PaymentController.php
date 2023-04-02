<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Helpers\OrderHelper;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(config('stripe.sk'));
        $user = Auth::user();

        if (count($user->cart->products) == 0) return back();

        $products = collect($user->cart->products)->map(function ($product) {
            return [
                'price_data' => [
                    'currency' => 'cad',
                    'product_data' => [
                        'name' => $product->brand
                    ],
                    'unit_amount' => $product->price * 100
                ],
                'quantity' => $product->pivot->quantity,
            ];
        })->all();

        $checkoutSession = Session::create([
            'line_items' => $products,
            'mode' => 'payment',
            'success_url' => route('payments.success'),
            'cancel_url' => route('carts.index')
        ]);
        return redirect()->away($checkoutSession->url);
    }

    public function success()
    {
        $user = Auth::user();
        $order = OrderHelper::create($user);
        $order->fresh();
        foreach ($user->cart->products as $product) {
            $order->addProducts($product);
            $user->cart->deleteAllProduct($product);
        }

        return redirect()->route('products.index');
    }
}
