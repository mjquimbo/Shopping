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


class CartsController extends Controller
{
    public function index(Request $request)
    {
        return view('carts.index');
    }

    public function checkout(Request $request)
    {
        return view('carts.checkout');
    }

    public function addProduct(Product $product)
    {
        if (Auth::check()) {
            $this->userAddProduct($product);
        } else {
            $this->guestAddProduct($product);
        }
    }

    public function deleteProduct(Product $product)
    {
        if (Auth::check()) {
            $this->userDeleteProduct($product);
        } else {
            $this->guestDeleteProduct($product);
        }
    }

    public function fetchCart(Request $request, Response $response)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $cart = [
                'isGuest' => false,
                'products' => $user->cart->products,
                'total_quantity' => $user->cart->total_quantity,
                'total_price' => $user->cart->total_price
            ];
            return response()->json($cart);
        }

        $guestCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = [
            'isGuest' => true,
            'products' => null,
            'total_quantity' => 0,
            'total_price' => 0
        ];
        if (is_null($guestCart)) return response()->json($cart);

        $cart = [
            'isGuest' => true,
            'products' => $guestCart->products,
            'total_quantity' => $guestCart->total_quantity,
            'total_price' => $guestCart->total_price
        ];
        return response()->json($cart);
    }

    private function userAddProduct(Product $product)
    {
        $user = Auth::user();
        $cartProducts = $user->cart->products;

        if ($cartProducts) {
            $cartProduct = $cartProducts->find($product->id);

            if ($cartProduct) {
                $cartProduct->pivot->update([
                    'quantity' => $cartProduct->pivot->quantity += 1,
                    'price' => $product->price * $cartProduct->pivot->quantity,
                ]);
                CartHelper::updateCart($user);
                return;
            }
        }

        CartProduct::create([
            'cart_id' => $user->cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);
        $user->cart->update([
            'total_quantity' => $user->cart->total_quantity += 1,
            'total_price' => $user->cart->total_price += $product->price
        ]);
    }

    private function userDeleteProduct(Product $product)
    {
        $user = Auth::user();
        $cartProducts = $user->cart->products;

        if ($cartProducts) {
            $cartProduct = $cartProducts->find($product->id);

            if ($cartProduct->pivot->quantity > 1) {
                $cartProduct->pivot->update([
                    'quantity' => $cartProduct->pivot->quantity -= 1,
                    'price' => $product->price * $cartProduct->pivot->quantity,
                ]);
                CartHelper::updateCart($user);
            } else {
                CartProduct::query()
                    ->where('cart_id', $user->cart->id)
                    ->where('product_id', $product->id)
                    ->delete();
                $user->cart->update([
                    'total_quantity' => $user->cart->total_quantity -= 1,
                    'total_price' => $user->cart->total_price -= $product->price
                ]);
            }
        }
    }

    private function guestAddProduct(Product $product)
    {
        $guestCart = Session::has('cart') ? Session::get('cart') : null;

        if (is_null($guestCart)) $guestCart = new GuestCart();

        if ($guestCart) {
            $cartProduct = current(array_filter($guestCart->products, function ($cartProduct) use ($product) {
                return $cartProduct->id == $product->id;
            }));

            if ($cartProduct) {
                $cartProduct->quantity = $cartProduct->quantity += 1;
                $cartProduct->price = $cartProduct->quantity * $product->price;
                $guestCart->updateGuestCart();
                Session::put('cart', $guestCart);
                return;
            }
        }
        $product['quantity'] = 1;
        $product['total'] = $product->price;
        $guestCart->products[] = $product;
        $guestCart->updateGuestCart();
        Session::put('cart', $guestCart);
    }

    private function guestDeleteProduct(Product $product)
    {
        $guestCart = Session::has('cart') ? Session::get('cart') : null;

        if (is_null($guestCart)) return;
        $cartProduct = [];
        $cartProduct = current(array_filter($guestCart->products, function ($cartProduct) use ($product) {
            return $cartProduct->id == $product->id;
        }));

        if ($cartProduct->quantity > 1) {
            $cartProduct->quantity = $cartProduct->quantity -= 1;
            $cartProduct->price = $cartProduct->quantity * $product->price;
            $guestCart->updateGuestCart();
            Session::put('cart', $guestCart);
            return;
        } else {
            $cartProduct = array_filter($guestCart->products, function ($cartProduct) use ($product) {
                return $cartProduct->id != $product->id;
            });
        }
        $guestCart->products = $cartProduct;

        $guestCart->updateGuestCart();
        Session::put('cart', $guestCart);
    }
}
