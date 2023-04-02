<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    protected $table = "carts";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'total_quantity',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'price']);
    }

    public function addProduct($product)
    {
        if ($this->products) {
            $cartProduct = $this->products->find($product['id']);

            if ($cartProduct) {
                $cartProduct->pivot->update([
                    'quantity' => $cartProduct->pivot->quantity += 1,
                    'price' => $product['price'] * $cartProduct->pivot->quantity,
                ]);
                $this->updateCart();
                return;
            }
        }

        CartProduct::create([
            'cart_id' => $this->id,
            'product_id' => $product['id'],
            'quantity' => 1,
            'price' => $product['price'],
        ]);

        $this->update([
            'total_quantity' => $this->total_quantity += 1,
            'total_price' => $this->total_price += $product['price']
        ]);
    }

    public function deleteProduct(Product $product)
    {
        if ($this->products) {
            $cartProduct = $this->products->find($product->id);

            if ($cartProduct->pivot->quantity > 1) {
                $cartProduct->pivot->update([
                    'quantity' => $cartProduct->pivot->quantity -= 1,
                    'price' => $product->price * $cartProduct->pivot->quantity,
                ]);
                $this->updateCart();
                return;
            }

            CartProduct::query()
                ->where('cart_id', $this->id)
                ->where('product_id', $product->id)
                ->delete();

            $this->update([
                'total_quantity' => $this->total_quantity -= 1,
                'total_price' => $this->total_price -= $product->price
            ]);
        }
    }

    public function deleteAllProduct(Product $product)
    {
        $productToDelete = $this->products->find($product->id);
        $quantity = $productToDelete->pivot->quantity;
        $price = $productToDelete->pivot->quantity * $product->price;

        CartProduct::query()
            ->where('cart_id', $this->id)
            ->where('product_id', $product->id)
            ->delete();

        $this->update([
            'total_quantity' => $this->total_quantity -= $quantity,
            'total_price' => $this->total_price -= $price
        ]);
    }

    public function addProducts($product)
    {
        if ($this->products) {
            $cartProduct = $this->products->find($product['id']);

            if ($cartProduct) {
                $cartProduct->pivot->update([
                    'quantity' => $cartProduct->pivot->quantity += 1,
                    'price' => $product['price'] * $cartProduct->pivot->quantity,
                ]);
                $this->updateCart();
                return;
            }
        }

        CartProduct::create([
            'cart_id' => $this->id,
            'product_id' => $product['id'],
            'quantity' => $product['pivot']['quantity'],
            'price' => $product['pivot']['price'],
        ]);

        $this->update([
            'total_quantity' => $this->total_quantity += $product['pivot']['quantity'],
            'total_price' => $this->total_price += $product['pivot']['price']
        ]);
    }

    public function updateCart()
    {
        $this->update([
            'total_quantity' => $this->products->sum('pivot.quantity'),
            'total_price' => $this->products->sum('pivot.price')
        ]);
    }


    public function testing()
    {

        $this->total_quantity = 22;
    }
}
