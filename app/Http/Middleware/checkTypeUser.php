<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;


class checkTypeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        if ($routeName == 'login.user') {
            if ($request->header('fcsToken')) {
                $credentials = request(['email', 'password']);

                if ($request['token'] = auth()->attempt($credentials)) {

                    $user = auth()->user();
                    if ($user->userRole->id == 2 or $user->userRole->id == 1)
                        return $next($request);

                    return response()->json(['message' => 'your email can not access this app'], 404);
                }
                return response()->json(['message' => 'unauthorized'], 404);
            }
            return response()->json(['message' => 'send device token'], 404);
        } else if ($user = auth()->user() and ($user->userRole->id == 2 or $user->userRole->id == 1)) {
            return $next($request);
        }
        return response()->json(['message' => 'please login'], 404);
    }
}