<?php

namespace App\Http\Controllers;

use App\Models\Product;


class ProductsController extends Controller
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
}
