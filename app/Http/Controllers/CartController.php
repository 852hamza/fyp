<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart($id)
    {
        $property = Property::find($id);

        if (!$property) {
            return redirect()->back()->with('error', 'Property not found!');
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('property_id', $id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'property_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Property added to cart successfully!');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('property_id', $id)
                        ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Property removed from cart successfully!');
    }
}
