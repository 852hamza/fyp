<?php

// app/Listeners/SyncCart.php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Session;
use App\Cart;

class SyncCart
{
    public function handle(Authenticated $event)
    {
        $user = $event->user;
        $cart = Session::get('cart', []);

        foreach ($cart as $propertyId => $details) {
            $cartItem = $user->cartItems()->where('property_id', $propertyId)->first();

            if ($cartItem) {
                $cartItem->quantity += $details['quantity'];
                $cartItem->save();
            } else {
                $user->cartItems()->create([
                    'property_id' => $propertyId,
                    'quantity' => $details['quantity']
                ]);
            }
        }

        Session::forget('cart');
    }
}


