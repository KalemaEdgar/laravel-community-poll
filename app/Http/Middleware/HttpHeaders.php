<?php

namespace App\Http\Middleware;

use Closure;

class HttpHeaders
{
    /**
     * Handle an incoming request.
     * Modify the response and add a header 'X-JOBS' with some text.
     * The modified headers will be sent back to the client
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $text Custom text to be used as the value of the X-JOBS header
     * @return mixed
     */
    public function handle($request, Closure $next, $text = '')
    {
        $response = $next($request);
        // $response->header('X-JOBS', 'Come work with us'); 
        $response->header('X-JOBS', $text); // Uses custom text value specified in the Kernel.php file under middleware (httpHeaders key)
        return $response;
    }
}
