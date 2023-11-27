<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\CompanyInformation;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function checkEmail($email)
    {
        $user = User::where('email', $email)->first();
        if ($user->email_verified_at)  #check on email verafication
            return $user;

        // $admin = Admin::where('email', $email)->first();
        // if ($admin)  #check on email verafication
        //     return $admin;

        return;
    }

    public function setNewPassword($password, $passwordReset, $user)
    {

        if (Carbon::parse($passwordReset->created_at) < Carbon::now()->addMinute(10)) {
            if ($user) {

                $user->update([
                    'password' => Hash::make($password)
                ]);
            }
            $passwordReset->delete();

            return response()->json(['message' => 'your password reset success']);
        }
        $passwordReset->delete();
        return response()->json(['message' => 'this link is expiry'], 404);
    }
}
