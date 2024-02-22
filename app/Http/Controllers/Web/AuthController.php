<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\AuthInterface;
use App\Http\Requests\changePasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\Web\AdminRequest;
use App\Http\Requests\Web\LogoRequest;

class AuthController extends Controller
{
    public function __construct(private AuthInterface $authInterface)
    {
    }

    public function login(LoginRequest $request)
    {
        return $this->authInterface->login($request);
    }
    
    public function logout()
    {
        return $this->authInterface->logout();
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->authInterface->forgetPassword($request);
    }

    function pageResetPassword($otp)
    {
        return $this->authInterface->pageResetPassword($otp);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->authInterface->resetPassword($request);
    }

    public function updatePassword(changePasswordRequest $request)
    {
        return $this->authInterface->updatePassword($request);
    }

    public function updateAdmin(AdminRequest $request)
    {
        return $this->authInterface->updateAdmin($request);
    }

    public function updateLogo(LogoRequest $request)
    {
        return $this->authInterface->updateLogo($request);
    }
}
