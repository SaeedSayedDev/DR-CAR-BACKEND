<?php

namespace App\Services;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{

    public function updateWallet($user_id, $net)
    {
        Wallet::updateOrCreate(
            ['user_id' => $user_id],
            [
                'total_balance' => DB::raw("total_balance + $net"),
                'awating_transfer' => DB::raw("total_balance + $net"),
            ],
        );
    }
}
