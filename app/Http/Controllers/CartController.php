<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Property;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->property->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Add item to cart with checking logic
    public function addToCart(Request $request)
    {
        $propertyId = $request->id;
        $userId = Auth::id();

        // Find the property by ID
        $property = Property::find($propertyId);
        if (!$property) {
            return response()->json(['error' => 'Property not found'], 404);
        }

        // Check if any property is already in the cart
        $existingCartItem = Cart::where('user_id', $userId)->first();

        if ($existingCartItem) {
            // If the same property is already in the cart
            if ($existingCartItem->property_id == $propertyId) {
                return response()->json([
                    'already_in_cart' => true,
                    'message' => 'This property is already in your cart!'
                ]);
            }

            // If a different property is already in the cart, ask for confirmation to replace it
            return response()->json([
                'replace_confirmation' => true,
                'message' => 'You already have a different property in the cart. Do you want to replace it?',
                'property_id' => $propertyId
            ]);
        }

        // Add the property to the cart (if no conflicts)
        Cart::create([
            'user_id' => $userId,
            'property_id' => $propertyId,
            'quantity' => 1,
        ]);

        return response()->json(['success' => 'Property added to cart successfully!']);
    }

    // Replace cart item logic
    public function replaceCartItem(Request $request)
    {
        $propertyId = $request->id;
        $userId = Auth::id();

        // Clear the existing cart
        Cart::where('user_id', $userId)->delete();

        // Add the new property to the cart
        Cart::create([
            'user_id' => $userId,
            'property_id' => $propertyId,
            'quantity' => 1,
        ]);

        return response()->json(['success' => 'Property replaced in the cart successfully!']);
    }

    // Remove item from the cart
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

    // Create Stripe Checkout Session
    public function createCheckoutSession()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $cartItems = Cart::where('user_id', Auth::id())->get();

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'pkr',  // Change to PKR
                    'product_data' => [
                        'name' => $item->property->title,  // Use property title
                    ],
                    'unit_amount' => $item->property->price * 100,  // Amount in paisa (cents equivalent)
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url);
    }

    // Handle successful checkout
    public function checkoutSuccess()
    {
        // Remove all cart items for the logged-in user
        Cart::where('user_id', Auth::id())->delete();

        return view('cart.success')->with('success', 'Payment successful, and your cart has been cleared.');
    }

    // Handle failed checkout
    public function checkoutCancel()
    {
        return view('cart.cancel')->with('error', 'Payment unsuccessful, your cart is unchanged.');
    }
}
