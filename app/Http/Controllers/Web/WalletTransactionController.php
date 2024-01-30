<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\WalletTransactionInterface;

class WalletTransactionController extends Controller
{
    public function __construct(private WalletTransactionInterface $slideInterface)
    {
    }

    public function __invoke()
    {
        return $this->slideInterface->index();
    }
}
