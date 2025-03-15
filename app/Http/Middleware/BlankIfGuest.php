<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BlankIfGuest
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response('', 200);
        }

        return $next($request);
    }
}
