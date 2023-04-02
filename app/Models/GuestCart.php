<?php

namespace App\Models;

use App\Models\Product;

class GuestCart
{
    public $products = [];
    public $total_quantity = 0;
    public $total_price = 0;

    public function addProduct(Product $product)
    {
        foreach ($this->products as &$sessionProduct) {
            if ($sessionProduct['id'] == $product->id) {
                $sessionProduct['pivot']['quantity'] += 1;
                $sessionProduct['pivot']['price'] = $product->price * $sessionProduct['pivot']['quantity'];
                $this->updateCart();
                return;
            }
        }

        $newProduct = [
            'id' => $product->id,
            'brand' => $product->brand,
            'description' => $product->description,
            'image' => $product->image,
            'model' => $product->model,
            'price' => $product->price,
        ];
        $newProduct['pivot']['quantity'] = 1;
        $newProduct['pivot']['price'] = $product->price;

        $this->products[] = $newProduct;
        $this->updateCart();
    }

    public function deleteProduct(Product $product)
    {
        foreach ($this->products as $index => &$sessionProduct) {
            if ($sessionProduct['id'] == $product->id) {
                if ($sessionProduct['pivot']['quantity'] > 1) {
                    $sessionProduct['pivot']['quantity'] -= 1;
                    $sessionProduct['pivot']['price'] = $product->price * $sessionProduct['pivot']['quantity'];
                } else {
                    unset($this->products[$index]);
                }
                $this->updateCart();
                return;
            }
        }
    }

    public function deleteAllProduct(Product $product)
    {
        foreach ($this->products as $index => &$sessionProduct) {
            if ($sessionProduct['id'] == $product->id) {
                unset($this->products[$index]);
                $this->updateCart();
                return;
            }
        }
    }

    public function updateCart()
    {
        $total_quantity = array_reduce($this->products, function ($carry, $products) {
            return $carry + $products['pivot']['quantity'] ?? 0;
        });
        $total_price = array_reduce($this->products, function ($carry, $products) {
            return $carry + $products['pivot']['price'];
        });

        $this->total_quantity =  is_null($total_quantity) ?  0 : $total_quantity;
        $this->total_price =  is_null($total_price) ?  0 : $total_price;
    }

    public function getCart()
    {
        return $this;
    }
}
