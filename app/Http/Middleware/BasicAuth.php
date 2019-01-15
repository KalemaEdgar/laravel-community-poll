<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BasicAuth
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
        // Laravel provides the Auth class to handle BasicAuth as below.
        // This uses the username and password from the database to authenticate the request
        return Auth::onceBasic() ?: $next($request);
        // return $next($request);
    }
}
