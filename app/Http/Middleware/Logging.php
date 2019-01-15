<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;

class Logging
{
    /**
     * Handle an incoming request.
     * The log is created in the Laravel log file under D:\xampp\htdocs\community-poll\storage\logs\laravel-2019-01-10.log
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info('Api processing started ==============================');
        Log::info('Start time: ' . date('Y-m-d H:i:s'));
        Log::debug('Method: ' . $request->method());
        return $next($request);
    }

    /**
     * Handle the response
     * The log is created in the Laravel log file under D:\xampp\htdocs\community-poll\storage\logs\laravel-2019-01-10.log
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response) 
    {
        $this->log($request, $response);
        // Log::debug($response->status());
    }

    /**
     * Format the log entries in the log file
     *
     * @param   $request
     * @return void
     */
    protected function log($request, $response)
    {
        // Log::info('Duration:  ' . number_format($this->end - $this->start, 3));
        Log::info('URL: ' . $request->fullUrl());
        Log::info('Method: ' . $request->getMethod());
        Log::info('IP Address: ' . $request->getClientIp());
        Log::info('Status Code: ' . $response->getStatusCode()); // or $response->status()
        Log::info('End time: ' . date('Y-m-d H:i:s'));
        Log::info('Api processing done ==================================' . PHP_EOL);
    }
}
