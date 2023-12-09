<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\OtpService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEnableAuth
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
        $user =  User::where('email', $request->email)->first();
        // $admin =  Admin::where('email', $request->email)->first();
        if (!$user)
            return response()->json(['message' => 'This User Is Not Found'], 404);

        if (!$user->email_verified_at) {
            $this->otpService->createEmail($user->email, $user->id, 'user');
            return response()->json(['message' => 'please verify your email']);
        }
        return $next($request);

        //  elseif ($admin) {
        //     return $next($request);
        // }
    }
}
