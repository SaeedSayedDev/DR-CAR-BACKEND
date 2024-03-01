<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\OtpService;
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

    public function __construct(private OtpService $otpService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();

        if ($routeName == 'login.provider') {
            if ($request->header('fcsToken')) {
                $credentials = request(['email', 'password']);

                if ($request['token'] = auth()->attempt($credentials)) {
                    if (auth()->user()->ban == 1)
                        return response()->json(['message' => 'your are rejected'], 404);
                    $user = auth()->user();
                    if ($user->userRole->id == 3 or $user->userRole->id == 4 or $user->userRole->id == 1) {
                        if (!$user->email_verified_at) {
                            return $this->otpService->createEmail($user->email, $user->id, 'user');
                        }
                        return $next($request);
                    }

                    return response()->json(['message' => 'your email can not access this app'], 404);
                }
                return response()->json(['message' => 'unauthorized'], 404);
            }
            return response()->json(['message' => 'send device token'], 404);
        } else if ($user = auth()->user() and ($user->userRole->id == 3 or $user->userRole->id == 4 or $user->userRole->id == 1)) {
            return $next($request);
        }
        return response()->json(['message' => 'please login provider'], 404);
    }
}
