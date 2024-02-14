<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\AuthInterface;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\OtpService;
use App\Services\PasswordService;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthInterface
{
    public function __construct(private OtpService $otpService, private PasswordService $passwordService)
    {
    }

    public function login($request)
    {
        $credentials = request(['email', 'password']);
        if (auth('web')->attempt($credentials)) {
            if (auth('web')->user()->role_id == 1) { // Admin
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                auth('web')->logout();
                return redirect()->back()->withErrors('Unauthorized');
            }
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('login.page');
    }

    public function forgetPassword($request)
    {
        $email = $request->validated()['email'];
        $user = User::where('email', $email)->first();
        if (!$user) return back();
        try {
            $this->otpService->createEmail($user->email, $user->id, 'admin');
            return back()->with('status', 'please check your email to set your new password');
        } catch (Exception $e) {
            return back();
        }
    }

    public function pageResetPassword($otp)
    {
        return view('auth.passwords.reset', ['otp' => $otp]);
    }

    public function resetPassword($request)
    {
        $user = User::where('email', $request->email)->whereHas('otpAdmin')->firstOrFail();

        if ($request->otp == $user->otpAdmin->otp and $user->otpAdmin->updated_at->addMinutes(10) >= now()) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('login.page')->with('success', trans('passwords.reset'));
        }
        return back()->with('error', 'this otp is expired');
    }

    public function updatePassword($request)
    {
        $user = auth()->user();

        if (!Hash::check($request->oldPassword, $user->password))
            return back()->with('error', 'Your old password is incorrect.');

        User::find($user->id)->update([
            'password' => Hash::make($request->newPassword)
        ]);

        return back()->with('success', 'Your password has been updated successfully.');
    }
}