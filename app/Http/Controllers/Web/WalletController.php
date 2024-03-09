<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\WalletInterface;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function __construct(private WalletInterface $slideInterface)
    {
    }

    public function index()
    {
        return $this->slideInterface->index();
    }

    public function wallet(Wallet $wallet)
    {
        return $this->slideInterface->wallet($wallet);
    }
}
