<?php

namespace App\Http\Middleware;

use Closure;

class GlobalCache
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
        $response= $next($request);
        $response->header('Cache-Control','max-age-86400');
        return $response;
    }
}
