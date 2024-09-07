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
            'name' => 'required|string|max:255',
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'phone' => 'required|regex:/^\+92\d{10}$/',
            'message' => 'required|min:7',
        ], [
            'email.regex' => 'Email must be a valid Gmail address (example@gmail.com).',
            'phone.regex' => 'Phone number must start with +92 followed by 10 digits.',
            'message.min' => 'The message must be at least 7 characters long.',
        ]);


        Mail::to('hamzaarain852sba@gmail.com')->send(new Contact($validated));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
