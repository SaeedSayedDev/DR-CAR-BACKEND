<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\OtpService;
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
    public function __construct(private OtpService $otpService)
    {
    }



    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        if ($routeName == 'login.user') {
            if ($request->header('fcsToken')) {
                $credentials = request(['email', 'password']);

                if ($request['token'] = auth()->attempt($credentials)) {
                    if (auth()->user()->ban == 1)
                        return response()->json(['message' => 'your are rejected'], 404);
                    $user = auth()->user();
                    if ($user->userRole->id == 2 or $user->userRole->id == 1) {
                        if (!$user->email_verified_at) {
                            return $this->otpService->createEmail($user->email, $user->id, 'user');
                        }
                        return $next($request);
                    }

                    return response()->json(['message' => 'your email can not access this app'], 404);
                }
                return response()->json(['message' => 'unauthorized'], 404);
            }
            return response()->json(['message' => 'send fcs token'], 404);
        } else if ($user = auth()->user() and ($user->userRole->id == 2 or $user->userRole->id == 1)) {

            return $next($request);
        }
        return response()->json(['message' => 'please login User'], 404);
    }
}
