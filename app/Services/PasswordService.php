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

        // return;
    }
}