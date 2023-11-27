<?php

namespace App\Http\Interfaces;

interface ConfirmEmailPhoneInterface
{
    //

    public function confirmCodePhone($request);
    
    public function confirmCodeEmail($request);

    public function sendCodePhone();
    

  

}