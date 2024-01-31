<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\WalletTransactionInterface;
use App\Models\AccountStatement;

class WalletTransactionRepository implements WalletTransactionInterface
{
    public function index()
    {
        $walletTransactions = AccountStatement::with(['wallet', 'user'])->paginate(10);
        return view('wallet_transactions.index', ['dataTable' => $walletTransactions]);
    }
}