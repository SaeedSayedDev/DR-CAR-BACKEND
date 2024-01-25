<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{

    public function updateWallet($user_id, $net)
    {

        Wallet::where('user_id', $user_id)->update(
            [
                'total_balance' => DB::raw("total_balance + $net"),
                'awating_transfer' => DB::raw("awating_transfer"),
                'total_earning' => DB::raw("total_earning + $net")
            ],
        );
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
