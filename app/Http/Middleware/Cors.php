<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        if($this->isInWhiteList($request->ip())) {
            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Headers', 'Authorization, App-Token');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, OPTION');

            return $response;
        } else {
            return $next($request);
        }
    }

    private function isInWhiteList($clientIp) {
        $whiteListIps = explode(",", env("WHITELIST_IP"));

        foreach ($whiteListIps as $ip) {
            if($ip ===  $clientIp) {
                return true;
            }
        }

        return false;
    }
}