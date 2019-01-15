<?php

namespace App\Http\Middleware;

use Closure;

class TokenAuth
{
    /**
     * Handle an incoming request.
     * Read the token being sent to the API
     * Check if its what was configured and respond accordingly
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('X-API-TOKEN');
        // Abort the operation if the token doesnot match
        // The token could be read from the database too for a specific user/client
        // This can be used in scenarios of validating the signatures / certificates before each request
        abort_if ($token != 'test-token123', 401, 'Auth token not found');

        return $next($request);
    }
}
