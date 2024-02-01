<?php

namespace App\Services;

use App\Models\setting\PaymentMethod;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\PaymentInformation;
use App\Services\ConvertCurrencyService;
use Illuminate\Support\Facades\DB;

class StripeService
{
    public $stripe;
    private $convertCurrencyServiceClass;


    // public function __construct(ConvertCurrencyService $convertCurrencyService)
    public function __construct(private BookingServices $bookingService, private WalletService $walletService)
    {

        // $paymentInformation = PaymentInformation::first();

        $this->stripe = new \Stripe\StripeClient(
            // env('STRIPE_SECRET')
            'sk_test_51MF0DNDDYgqi6JEXNu4i7Hzu73mpnEvvRimgn47FIwAUpBvnC6odJRFdPoNdzUA842GuQTUyPY4Kp3RecIGdFogT00uBobmCkG'

        );
        // $this->convertCurrencyServiceClass = $convertCurrencyService;
    }

    public function stripeCharge($token, $invoice_value)
    {
        // $invoiceValue = $this->convertCurrencyServiceClass->convartCurrencyInvoiceToAED($invoice_currency, $invoice_value) * 100;
        return $this->stripe->charges->create([
            "amount" => (int)$invoice_value * 100,
            "currency" => 'AED',
            "source" => $token,
        ]);
    }



    public function stripeChargeRetrieve($charge_id)
    {
        return  $this->stripe->charges->retrieve(
            $charge_id,
            ["expand" => array("balance_transaction")]
        );
    }
    public function stripeRefund($charge_id, $amount = null)
    {
        if ($amount) {
            $amountRefund = $amount * 100;
            return $this->stripe->refunds->create([
                'charge' => $charge_id,
                'amount' =>   (int)$amountRefund,
                ["expand" => array("balance_transaction")]
            ]);
        }

        return $this->stripe->refunds->create([
            'charge' => $charge_id
        ]);
    }
    public function createTokenCard($dataCard)
    {
        return $this->stripe->tokens->create([
            'card' => [
                'number' => $dataCard['card_number'],
                'exp_month' => $dataCard['exp_month'],
                'exp_year' => $dataCard['exp_year'],
                'cvc' => $dataCard['cvc'],
            ],
        ]);
    }
    // public function stripeFee($payment)
    // {
    //     $payment = PaymentMethod::where('name_en', $payment)->with('payment_method')->first();
    //     if ($payment->payment_method->commission_from_id == 1) {
    //         return;
    //     }
    // }
    public function  payWithStripe($request, $bookingService, $total_amount, $retrieve)
    {

        $payment_amount_winch = isset($bookingService->booking_winch) ? $bookingService->booking_winch->payment_amount : 0;

        $netDivision = $this->bookingService->netDivision($bookingService->delivery_car, $bookingService->payment_amount, $payment_amount_winch, $retrieve->balance_transaction->net / 100);

        if ($bookingService->delivery_car == true and isset($bookingService->booking_winch)) {
            $this->bookingService->updateBooking($bookingService->booking_winch, 2, $retrieve->id);
            $winchNetAfterCommission = $this->bookingService->commissionNet($payment_amount_winch, $netDivision['winch_net']);
            $this->walletService->updateWallet($bookingService->booking_winch->winch_id, $winchNetAfterCommission, 'booking', $bookingService->user_id, $request->payment_type, $payment_amount_winch);
        }

        $garageNetAfterCommission = $this->bookingService->commissionNet($bookingService->payment_amount, $netDivision['garage_net']);
        $this->bookingService->updateBooking($bookingService, 2, $retrieve->id);
        $this->walletService->updateWallet($bookingService->serviceProvider->provider->garage_id, $garageNetAfterCommission, 'booking', $bookingService->user_id, $request->payment_type, $bookingService->payment_amount);

        DB::commit();
        return response()->json(['message' => 'success']);
    }
}
