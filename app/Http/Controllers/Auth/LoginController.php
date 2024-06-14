<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
