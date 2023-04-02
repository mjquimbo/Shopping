<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use Hash;
use Session;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function verifyLogIn(Request $request)
    {
        $request->validate([
            'username' => ['required', 'exists:users'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $guestCart = Session::has('cart') ? Session::get('cart') : null;
            if (!is_null($guestCart) && $guestCart->products) {
                $user = Auth::user();
                foreach ($guestCart->products as $product) {
                    $user->cart->addProducts($product);
                }
            }
            return redirect()->route('products.index');
        }

        return back()->with('password', 'The selected password is invalid.');
    }

    public function signUp()
    {
        return view('auth.signup');
    }

    public function verifySignUp(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

        $this->create($request->all());
        return redirect()->route('login');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('products.index');
    }

    public function create(array $user)
    {
        $newUser = User::create([
            'name' => $user['name'],
            'username' => $user['username'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
            'contact_number' => $user['contact_number'], 
            'address' => $user['address']
        ]);
        $newUser->fresh();
        Cart::create([
            'user_id' => $newUser->id,
            'total_quantity' => 0,
            'total_price' => 0
        ]);

        return $newUser;
    }
}
