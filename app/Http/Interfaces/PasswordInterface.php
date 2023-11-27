<?php

namespace App\Http\Interfaces;

interface PasswordInterface
{
    
    public function forgetPassword($request);
    public function resetPassword($request);
    public function changePassword($request);
    
}
