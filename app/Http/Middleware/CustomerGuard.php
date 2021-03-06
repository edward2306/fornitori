<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CustomerGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = JWTAuth::parseToken()->toUser()->role;

        return $role === 'customer' ? $next($request) : abort(403, 'Forbidden');
    }
}
