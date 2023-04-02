<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\GuestCart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {

        $productList = Product::paginate(12);
        return view('products.index', compact('productList'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function addProduct(Product $product)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->cart->addProduct($product);
        } else {
            $guestCart = Session::has('cart') ? Session::get('cart') : null;

            if (is_null($guestCart)) $guestCart = new GuestCart();

            $guestCart->addProduct($product);

            Session::put('cart', $guestCart);
        }
    }

    public function deleteProduct(Product $product)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->cart->deleteProduct($product);
        } else {
            $guestCart = Session::has('cart') ? Session::get('cart') : null;

            if (is_null($guestCart)) return;

            $guestCart->deleteProduct($product);

            Session::put('cart', $guestCart);
        }
    }

    public function deleteAllProduct(Product $product)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->cart->deleteAllProduct($product);
        } else {
            $guestCart = Session::has('cart') ? Session::get('cart') : null;

            if (is_null($guestCart)) return;

            $guestCart->deleteAllProduct($product);

            Session::put('cart', $guestCart);
        }
    }
}
