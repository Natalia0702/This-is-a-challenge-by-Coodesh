<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
{   
    Log::info('CorsMiddleware is being executed');
    
    header('Access-Control-Allow-Origin', '*');
    
    $headers = [
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization, login'
    ];
    
    if ($request->getMethod() == "OPTIONS") {
        return response()->make('OK', 200, $headers);
    }

    $response = $next($request);

    foreach ($headers as $key => $value) {
        $response->header($key, $value);
    }

    return $response;
    }
}
