<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\PasswordInterface;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\OtpService;
use App\Services\PasswordService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordRepository implements PasswordInterface
{

    public function __construct(private OtpService $otpService, private PasswordService $passwordService)
    {
    }

    public function forgetPassword($request)
    {
        $user = $this->passwordService->checkEmail($request->email);
        if (!$user) {
            return response()->json(['message' => 'This email is not found or confirm it first'], 404);
        }

        PasswordReset::create(['email' => $user->email, 'created_at' => now()]);
        try {
            $this->otpService->createEmail($user->email, $user->id, 'user');
            return response()->json(['message' => 'please check your email to set your new password']);
        } catch (Exception $e) {
            return  response()->json(['message' => $e->getMessage()], 404);
        }
    }


    public function resetPassword($request)
    {
        $user = $this->passwordService->checkEmail($request->email);
        if (!$user)
            return response()->json(['message' => 'This Sender is not found or confirm it first'], 404);

        $passwordReset =  PasswordReset::Where('email', $user->email)->first();

        if (isset($passwordReset)) {
            if (request()->route('otp') == $user->otpUser->otp and $user->otpUser->updated_at->addMinutes(10) >= Carbon::now()) {
                return  $this->passwordService->setNewPassword($request->password, $passwordReset, $user);
            } else {
                return response()->json(['message' => 'This code is not correct or expire'], 401);
            }
        }
    }

    public function changePassword($request)
    {
        $user = auth()->user();

        if (!Hash::check($request->oldPassword, $user->password))
            return response()->json(['message' => 'The old password is incorrect'], 404);

        User::find($user->id)->update([
            'password' => Hash::make($request->newPassword)
        ]);

        return response()->json(['message' => 'Your password changed success']);
    }
}
