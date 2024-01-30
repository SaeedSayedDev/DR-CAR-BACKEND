<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\WalletInterface;

class WalletController extends Controller
{
    public function __construct(private WalletInterface $slideInterface)
    {
    }

    public function __invoke()
    {
        return $this->slideInterface->index();
    }
}
