<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\WalletInterface;
use App\Models\Wallet;

class WalletRepository implements WalletInterface
{
    public function index()
    {
        $wallets = Wallet::with('user')->paginate(10);

        return view('wallets.index', ['dataTable' => $wallets]);
    }

    public function wallet($wallet)
    {
        $wallets = Wallet::where('id', $wallet->id)->with('user')->paginate(10);
        
        return view('wallets.index', ['dataTable' => $wallets]);
    }
}