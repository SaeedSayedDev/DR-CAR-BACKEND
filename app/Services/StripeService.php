<?php

namespace App\Services;

use App\Models\setting\PaymentMethod;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\PaymentInformation;
use App\Services\ConvertCurrencyService;

class StripeService
{
    public $stripe;
    private $convertCurrencyServiceClass;

    // public function __construct(ConvertCurrencyService $convertCurrencyService)
    public function __construct()
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
}