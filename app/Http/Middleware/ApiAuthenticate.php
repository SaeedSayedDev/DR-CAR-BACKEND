<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()) {
            if (auth()->user()->ban == 1)
                return response()->json(['message' => 'your are rejected'], 404);
            return $next($request);
        }
        // else if (auth()->guard('admin')->user()) {
        //     return  $next($request);
        // }
        return response()->json([
            'message' => 'Please Login'
        ], 404);
    }
}
