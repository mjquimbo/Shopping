<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $table = "orders";
    protected $primaryKey = "id";


    protected $fillable = [
        'user_id',
        'total_quantity',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'price']);
    }

    public function addProducts($product)
    {
        OrderProduct::create([
            'order_id' => $this->id,
            'product_id' => $product->id,
            'quantity' => $product->pivot->quantity,
            'price' => $product->pivot->price,
        ]);
    }
}
