<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\WalletInterface;
use App\Http\Requests\chargeWalletRequest;
use App\Http\Requests\confirmWithdraw;
use App\Http\Requests\WithdrawWalletRequest;


class WalletController extends Controller
{

    public function __construct(private WalletInterface $walletInterface)
    {
    }

    public function chargeWallet(chargeWalletRequest $request)
    {
        return $this->walletInterface->chargeWallet($request);
    }

    public function WithdrawWallet(WithdrawWalletRequest $request)
    {
        return $this->walletInterface->WithdrawWallet($request);
    }
    
    public function cancel($withdraw_id){
        return $this->walletInterface->cancel($withdraw_id);
    }

    public function confirm_admin(confirmWithdraw $request , $withdraw_id ){
        return $this->walletInterface->confirm_admin($withdraw_id, $request);
    }
    
}
