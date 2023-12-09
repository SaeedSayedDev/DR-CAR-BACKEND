<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkTypeProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user and ($user->role_id == 4 or $user->role_id == 3)) {
            return $next($request);
        } elseif (!$user) {
            $user =  User::where('email', $request->email)->where('role_id', 3)->orWhere('email', $request->email)->where('role_id', 4)->first();
            if ($user)
                return $next($request);
            else
                return response()->json(['message' => 'your email is not correct or has not premession'], 404);
        } else
            return response()->json(['message' => 'your email can not access this api'], 404);
    }
}
