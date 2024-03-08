<?php

namespace App\Http\Interfaces\Web;

interface WalletInterface
{
    public function index();

    public function wallet($wallet);
}
