<?php

namespace App\Services;

use App\Models\AccountStatement;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(private BookingServices $bookingService, private ConvertCurrencyService $convertCurrencyService, private NotificationService $notificationService, private ImageService $imageService)
    {
    }

    public function updateWallet($user_id_who_he_recieve_money, $net, $desc, $user_id_who_he_send_money, $payment_type, $payment_amount)
    {

        $wallet =  Wallet::where('user_id', $user_id_who_he_recieve_money)->first();
        $wallet->update(
            [
                'total_balance' => $wallet->total_balance + $net,
                'total_earning' => $wallet->total_earning  + $net
            ],
        );
        AccountStatement::create([
            'amount' => $net,
            'description' => $desc,
            'action' => 'credit',
            'wallet_id' => $wallet->id,
            'user_id' => $user_id_who_he_send_money,
        ]);

        if ($payment_type == 3 and $desc == 'booking') {
            $wallet =  Wallet::where('user_id', $user_id_who_he_send_money)->first();
            $wallet->update(
                [
                    'total_balance' => $wallet->total_balance - $payment_amount,
                ],
            );
        }
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
                'description' => 'withdraw',
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


    public function payWithWallet($request, $bookingService, $total_amount)
    {
        $user_id = auth()->user()->id;

        $wallet = Wallet::where('user_id', $user_id)->first();

        if (isset($bookingService->booking_winch)) {
            if ($wallet->total_balance < $bookingService->booking_winch->payment_amount + $bookingService->payment_amount)
                return response()->json(['message' => 'please charge your wallet first']);

            $payment_amount_winch = $bookingService->booking_winch->payment_amount;
        } else {
            if ($wallet->total_balance < $bookingService->payment_amount)
                return response()->json(['message' => 'please charge your wallet first']);
            $payment_amount_winch = 0;
        }

        $payment_amount_winch = isset($bookingService->booking_winch) ? $bookingService->booking_winch->payment_amount : 0;

        $netDivision = $this->bookingService->netDivision($bookingService->delivery_car, $bookingService->payment_amount, $payment_amount_winch, $total_amount);

        if ($bookingService->delivery_car == true and isset($bookingService->booking_winch)) {
            $this->bookingService->updateBookingWinch($bookingService->booking_winch, 2, 'wallet');
            $winchNetAfterCommission = $this->bookingService->commissionNet($payment_amount_winch, $netDivision['winch_net']);
            $this->updateWallet($bookingService->booking_winch->winch_id, $winchNetAfterCommission, 'booking', $bookingService->user_id, $request->payment_type, $payment_amount_winch);
        }

        $garageNetAfterCommission = $this->bookingService->commissionNet($bookingService->payment_amount, $netDivision['garage_net']);
        $this->bookingService->updateBooking($bookingService, 3, 'wallet');
        $this->updateWallet($bookingService->serviceProvider->provider->garage_id, $garageNetAfterCommission, 'booking', $bookingService->user_id, $request->payment_type, $bookingService->payment_amount);

        DB::commit();

        return response()->json(['message' => 'success']);
    }
}
