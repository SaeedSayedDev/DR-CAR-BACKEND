<?php

namespace App\Http\Interfaces;

interface PasswordInterface
{

    public function forgetPassword($request);
    public function resetPasswordApi($request);

    public function resetPassword($request);
    public function pageResetPassword($otp);
    public function changePassword($request);
}
