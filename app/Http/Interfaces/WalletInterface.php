<?php

namespace App\Http\Interfaces;


interface WalletInterface
{

    public function chargeWallet($request);

    public function WithdrawWallet($request);
    public function cancel($withdraw_id);
    public function confirm_admin($request, $withdraw_id);
}
