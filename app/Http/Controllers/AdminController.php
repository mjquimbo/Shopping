<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class AdminController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->whereNot("username", "admin")
            ->get();
        $products = Product::all();

        return view('admin.index', compact(['users', 'products']));
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $image = $request->file('image');
        $product = json_decode($request->input("product"));
        $filename = $product->id . '.' . $image->getClientOriginalName();
        $imagePath = $product->image;
        $imagePathArray = explode('/', $imagePath);

        if (Storage::exists('public/images/' . end($imagePathArray))) {
            Storage::delete('public/images/' . end($imagePathArray));
        }

        $success = false;
        $updateProduct = Product::find($product->id);

        if (!is_null($updateProduct)) {
            $image->storeAs('public/images', $filename);
            $updateProduct->update([
                'image' => 'storage/images/' . $filename,
            ]);
            $success = true;
        }
        return response()->json(['product' => $updateProduct, 'success' => $success]);
    }

    public function orders(Request $request)
    {
        $user = Order::query()
            ->where('user_id', $request->get('userId'))
            ->get();
        return response()->json($user);
    }
}
