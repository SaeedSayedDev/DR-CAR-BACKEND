<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\WalletInterface;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Service;
use App\Models\Slide;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Services\ConvertCurrencyService;
use App\Services\ImageService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;

class WalletRepository implements WalletInterface
{
    public function __construct(private StripeService $stripeService, private PaypalService $paypalService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService)
    {
    }

    public function chargeWallet($request)
    {
        $user_id = auth()->user()->id;
        $payment_method =  PaymentMethod::where('enabled', 1)->where('payment_type', $request->payment_type)->first();

        if ($payment_method->name == 'Stripe') {

            $retrieve = $this->payWithStripe($request, $request->amount);

            $this->walletService->updateWallet(auth()->user()->id, $retrieve->balance_transaction->net / 100);

            return response()->json(['message' => 'success']);
        } elseif ($payment_method->name == 'Paypal') {
            $amount_usd = $this->convertCurrencyService->convertAmountFromAEDToUSA($request->amount);

            return  $this->paypalService->createOrder($amount_usd, $user_id, 'user');
        }
    }


    public function WithdrawWallet($request)
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->first();

        if ($request->amount > $wallet->total_balance - $wallet->awating_transfer) {
            return response()->json(['message' => 'amount should be less than ' . ($wallet->total_balance - $wallet->awating_transfer)], 404);
        }

        DB::beginTransaction();

        Withdraw::create([
            'amount' => $request->amount,
            'user_id' => $user->id,
        ]);

        $wallet->update([
            'awating_transfer' => $wallet->awating_transfer + $request->amount,
        ]);
        DB::commit();
        return response()->json(['message' => 'success']);
    }

    public function cancel($id)
    {
        $user = auth()->user();
        $Withdraw = Withdraw::where('user_id', $user->id)
            ->where('status', 'pending')->orWhere('status', 'processing')
            ->find($id);

        if ($Withdraw) {
            $wallet = Wallet::where('user_id', $Withdraw->user_id)->firstOrFail();

            $wallet->awating_transfer -= $Withdraw->amount;

            $wallet->update([
                'awating_transfer' => $wallet->awating_transfer,
            ]);
            $Withdraw->update(['status' => 'canceled']);
            return response()->json(['message' => 'success']);
        }
        return response()->json(['message' => 'you can not cancel this request'] , 404);
    }

    function payWithStripe($request, $payment_amount)
    {
        $cardData = $this->stripeService->createTokenCard($request->all());
        $charge = $this->stripeService->stripeCharge($cardData->id, $payment_amount);
        $retrieve = $this->stripeService->stripeChargeRetrieve($charge->id);
        return $retrieve;
    }

    ///////////////// from admin ///////////////////////
    public function confirm_admin($withdraw_id, $request)
    {
        // $withdraw = Withdraw::where('status', 'pending')->where('id', $withdraw_id)
        //     ->orWhere('status', 'processing')->where('id', $withdraw_id)
        //     ->firstOrFail();
        $withdraw = Withdraw::where('status', 'pending')
            ->orWhere('status', 'processing')
            ->find($withdraw_id);

        $wallet = Wallet::where('user_id', $withdraw->user_id)->firstOrFail();

        if ($withdraw->amount <= $wallet->total_balance) {

            $this->walletService->updateWalletAndWithdraw($request, $wallet, $withdraw);

            return response()->json(['message' => 'success']);
        }
        return response()->json(['message' => 'wallet of the profile amount con not be enough'], 404);
    }
}
