<?php

namespace App\Http\Interfaces;

interface AuthInterface
{
    public function login($request);

    public function logout();

    public function register($request);
    // public function user_register($request);
    
    public function me();
}