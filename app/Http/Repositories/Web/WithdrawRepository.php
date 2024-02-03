<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\WithdrawInterface;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Services\WalletService;

class WithdrawRepository implements WithdrawInterface
{
    public function __construct(private WalletService $walletService)
    {
    }

    public function index()
    {
        $withdraws = Withdraw::with('user')->paginate(10);

        return view('withdraws.index', ['dataTable' => $withdraws]);
    }

    public function show($id)
    {
        $withdraw = Withdraw::findOrFail($id)->load('user');

        return view('withdraws.show', compact('withdraw'));
    }

    public function filterStatus($request)
    {
        $status = $request->only('status');
        
        $withdraws = Withdraw::with('user')->where($status)->paginate(10);

        return view('withdraws.index', ['dataTable' => $withdraws]);
    }

    public function updateStatus($request, $id)
    {
        $withdraw = Withdraw::findOrFail($id);
        $status = $request->only('status');

        if ($withdraw->status == 'paid' || $withdraw->status == 'unpaid') {
            return back()->withErrors('You cannot change paid/unpaid status');
        } else if ($status['status'] == 'pending' && $withdraw->status == 'processing') {
            return back()->withErrors('You cannot change processing status to pending status');
        }
        $wallet = Wallet::where('user_id', $withdraw->user_id)->firstOrFail();
        
        if ($withdraw->amount <= $wallet->total_balance) {
            $this->walletService->updateWalletAndWithdraw($request, $wallet, $withdraw);

            return redirect()->route('withdraws.index')->with([
                'message' => 'Status updated successfully',
            ]);
        }

        return back()->withErrors('wallet of the profile amount cannot be enough');
    }
}