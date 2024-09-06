<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;  // Ensure you have this Mailable
// use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        Mail::to('hamzaarain852sba@gmail.com')->send(new Contact($validated));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
