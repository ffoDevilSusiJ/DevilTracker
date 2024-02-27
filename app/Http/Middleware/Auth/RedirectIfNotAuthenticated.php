<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            $request->session()->put('url.intended', $request->fullUrl());
            return redirect('/login'); // Перенаправление на страницу авторизации
        }

        return $next($request);
    }
}