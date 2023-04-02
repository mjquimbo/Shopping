<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\GuestCart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function index(Request $request)
    {
        return view('carts.index');
    }

    public function checkout(Request $request)
    {
        return view('carts.checkout');
    }

    public function fetchCart()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $cart = [
                'products' => $user->cart->products,
                'total_quantity' => $user->cart->total_quantity,
                'total_price' => $user->cart->total_price
            ];

            return response()->json($cart);
        }

        $guestCart = Session::has('cart') ? Session::get('cart') : null;

        if (is_null($guestCart)) return response()->json(new GuestCart());

        $cart = $guestCart->getCart();

        $cart = [
            'products' => $cart->products,
            'total_quantity' => $cart->total_quantity,
            'total_price' =>  $cart->total_price,
        ];
        return response()->json($cart);
    }
}
