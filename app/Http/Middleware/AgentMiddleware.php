<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AgentMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->id == 2) {
            Log::info('AgentMiddleware: User is authenticated and has agent role', ['user_id' => Auth::user()->id]);
            return $next($request);
        } else {
            Log::info('AgentMiddleware: User is not authenticated or does not have agent role', ['requested_path' => $request->path()]);
            // Redirect to login with intended URL parameter
            return redirect()->route('login', ['intended' => $request->path()]);
        }
    }
}


