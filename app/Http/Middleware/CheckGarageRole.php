<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGarageRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || $request->user()->role_id !== 4) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
