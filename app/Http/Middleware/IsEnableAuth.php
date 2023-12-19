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
        if ($request->header('fcsToken')) {
            $user =  User::where('email', $request->email)->first();
            if (!$user)
                return response()->json(['message' => 'This User Is Not Found'], 404);

            return $next($request);

            //  elseif ($admin) {
            //     return $next($request);
            // }
        }
        return response()->json(['message' => 'Please Send Firbase Token'], 404);
    }
}
