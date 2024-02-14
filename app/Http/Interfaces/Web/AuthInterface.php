<?php

namespace App\Http\Interfaces\Web;

interface AuthInterface
{
    public function login($request);

    public function logout();

    public function forgetPassword($request);

    public function resetPassword($request);

    public function pageResetPassword($otp);

    public function updatePassword($request);
}
