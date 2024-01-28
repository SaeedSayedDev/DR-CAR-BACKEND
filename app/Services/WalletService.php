<?php

namespace App\Services;

use App\Models\AccountStatement;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{

    public function updateWallet($user_id_who_he_recieve_money, $net, $desc, $user_id_who_he_send_money)
    {

        $wallet =  Wallet::where('user_id', $user_id_who_he_recieve_money)->first();
        $wallet->update(
            [
                'total_balance' => DB::raw("total_balance + $net"),
                'awating_transfer' => DB::raw("awating_transfer"),
                'total_earning' => DB::raw("total_earning + $net")
            ],
        );
        AccountStatement::create([
            'amount' => $net,
            'description' => $desc,
            'action' => 'credit',
            'wallet_id' => $wallet->id,
            'user_id' => $user_id_who_he_send_money,
        ]);
    }

    function updateWalletAndWithdraw($request, $wallet, $withdraw)
    {
        DB::beginTransaction();

        if ($request->status == 'paid') {

            $wallet->update([
                'awating_transfer' => ($wallet->awating_transfer - $withdraw->amount),
                'total_balance' => ($wallet->total_balance - $withdraw->amount),
            ]);
            $withdraw->update(['status' => $request->status]);

            AccountStatement::create([
                'amount' => $withdraw->amount,
                'description' =>'withdraw',
                'action' => 'debit',
                'wallet_id' => $wallet->id,
                'user_id' => $wallet->user_id,
            ]);
        } else if ($request->status == 'unpaid') {

            $wallet->update([
                'awating_transfer' => ($wallet->awating_transfer - $withdraw->amount),
            ]);
            $withdraw->update(['status' => $request->status]);
        } else {
            $withdraw->update(['status' => $request->status]);
        }
        DB::commit();
    }
}
