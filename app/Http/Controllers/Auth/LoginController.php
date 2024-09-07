<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\User; // Make sure this path matches your User model
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default fallback redirect
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        // Default role-based redirection
        $user = auth()->user();

        Log::info('Redirecting user based on role', ['user_id' => $user->id, 'role' => $user->role->name]);

        if ($user->hasRole('Admin')) {
            return route('admin.dashboard');
        } elseif ($user->hasRole('Agent')) {
            return route('agent.dashboard');
        } elseif ($user->hasRole('User')) {
            return route('user.dashboard');
        }

        return $this->redirectTo;
    }

    protected function authenticated(Request $request, $user)
    {
        Log::info('User authenticated', ['user_id' => $user->id, 'intended' => session('url.intended')]);

        // Redirect to the intended URL if it exists, otherwise use role-based redirect
        return redirect()->intended($this->redirectTo());
    }

    public function showLoginForm(Request $request)
    {
        $intended = $request->query('intended');
        if ($intended) {
            $request->session()->put('url.intended', $intended);
            Log::info('Showing login form', ['intended' => $intended]);
        }
        return view('auth.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // User does not exist, create a new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id, // Ensure your users table has a 'google_id' column
                    'username' => strtolower(strtok($googleUser->name, ' ')), // Generates username from Google name
                    'role_id' => 3, // Default to a 'User' role, adjust as necessary
                    'password' => Hash::make(uniqid()), // Random password
                    'image' => 'default.png', // Default image
                    'about' => '', // Default about, adjust as necessary
                ]);
            }

            auth()->login($user, true);
            return redirect($this->redirectTo());
        } catch (\Exception $e) {
            Log::error('Error in Google Callback', ['error' => $e->getMessage()]);
            return redirect('login')->with('error', 'Failed to authenticate with Google.');
        }
    }
}
