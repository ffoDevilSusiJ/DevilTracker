<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotActived
{
    public function handle($request, Closure $next)
    {
        if(!auth()->user()->active) {
            return response()->view('auth.stab');
        }
        return $next($request);
    }
}