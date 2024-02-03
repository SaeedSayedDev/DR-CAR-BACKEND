<?php

namespace App\Services;

use App\Models\BookingService;
use App\Models\BookingWinch;
use App\Services\BookingServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Omnipay\Omnipay;
use PayPal\Api\Payment;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;



class PaypalService
{
    private $client_id;
    private $secret_id;

    public function __construct(private BookingServices $bookingService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService)
    {
        $this->client_id = env('PAYPAL_CLIENT_ID');
        $this->secret_id = env('PAYPAL_CLIENT_SECRET');
    }
    public function createOrder($amount, $custom_id, $type)
    {
        // dump($custom_id);
        // dd($type);
        try {
            $data = $this->data($amount, $custom_id, $type);
            $res = Http::withBasicAuth($this->client_id, $this->secret_id)
                ->post(
                    'https://api-m.sandbox.paypal.com/v2/checkout/orders',
                    $data
                );
            return response()->json(['message' => $res['links'][1]['href']]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }


    function data($amount, $custom_id, $type)
    {
        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($amount, 2, '.', '') // Amount for the order
                    ],

                    "custom_id" => "$custom_id",
                    'soft_descriptor' => "$type"

                ]
            ],
            'application_context' => [
                'return_url' => url('success'),
                'cancel_url' => url('error')
            ]
        ];
    }


    public function success($request)
    {
        try {
            DB::beginTransaction();

            $paypalDetails = $this->getPaypalDetails($request->paypal_id);
            $net_usd = $paypalDetails['amount'] - $paypalDetails['fees'];
            $net_aed = $this->convertCurrencyService->convertAmountFromUSDToAED($net_usd);
            if ($request->type == 'booking') {

                $booking_service = BookingService::with('booking_winch')->find($request->booking_id);

                $payment_amount_winch = isset($booking_service->booking_winch) ? $booking_service->booking_winch->payment_amount : 0;
                $netDivision = $this->bookingService->netDivision($booking_service->delivery_car, $booking_service->payment_amount, $payment_amount_winch, $net_aed);

                if (isset($booking_service->booking_winch) and $booking_service->delivery_car == true) {
                    $winchNetAfterCommission = $this->bookingService->commissionNet($payment_amount_winch, $netDivision['winch_net']);
                    $this->bookingService->updateBooking($booking_service->booking_winch, 1, $request['token']);
                    $this->walletService->updateWallet($booking_service->booking_winch->winch_id, $winchNetAfterCommission, 'booking', $booking_service->user_id, $request->payment_type, $payment_amount_winch);
                }

                $garageNetAfterCommission = $this->bookingService->commissionNet($booking_service->payment_amount, $netDivision['garage_net']);
                
                $this->bookingService->updateBooking($booking_service, 1, $request['token']);
                $this->walletService->updateWallet($booking_service->serviceProvider->provider->garage_id, $garageNetAfterCommission, 'booking', $booking_service->user_id, $request->payment_type, $booking_service->payment_amount);
            } else if ($request->type  == 'user')/* wallet == user  */ {
                $this->walletService->updateWallet(auth()->user()->id, $net_aed, 'charge wallet', auth()->user()->id, $request->payment_type, $net_aed);
            }
            DB::commit();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }



    function capture_and_retrieve_order($order_id)
    {
        Http::withBasicAuth($this->client_id, $this->secret_id)->post(
            "https://api-m.sandbox.paypal.com/v2/checkout/orders/$order_id/capture",
            [
                'note_to_payer' => 'Thank you',
            ]
        );
        $retrieveOrder = Http::withBasicAuth($this->client_id, $this->secret_id)
            ->get(
                "https://api-m.sandbox.paypal.com/v2/checkout/orders/$order_id"
            );
        return $retrieveOrder;
    }

    public function getPaypalDetails($transactionId)
    {

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'ATvM3mEtUPKHBfv8ySMMKVyq09KCKrc0l-5e3S3_KIgbgV17RMKc4L8D30sPHGsImt2FBDYgOmkhzfZ5', #clientId
                'EI3TdIu9pd165ljeVOQlZjRHgV9PLRUSs9wGjf3GJpJuQMbt4aRdkiLFJiIhngf-P_I1oPw4SS573Uc1' #secretKey
            )
        );
        $transactionId = 'PAYID-MW5KTLA8WU55766UR388811Y';

        // Set the PayPal API context
        $apiContext->setConfig([
            'mode' => 'sandbox', // Change to 'live' for production
        ]);

        try {
            // Retrieve the payment details using the transaction ID
            $payment = Payment::get($transactionId, $apiContext);

            // Access details from the $payment object
            $transactionDetails = [
                'id' => $payment->getId(),
                'amount' => $payment->getTransactions()[0]->getAmount()->getTotal(),
                'fees' => $payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getTransactionFee()->getValue(),
                'customId' => $payment->getTransactions()[0]->getCustom(),
                'softDescriptor' => $payment->getTransactions()[0]->getSoftDescriptor(),
                'status' => $payment->getState(), // or $payment->getIntent() for the payment intent
                'payerId' => $payment->getPayer()->getPayerInfo()->getPayerId(),
                // 'netAmount' => $payment->getTransactions()[0]->getAmount()->getDetails()->getNetAmححount()

            ];
            return $transactionDetails;
            // $details = $payment->getTransactions()[0]->getAmount()->getDetails();
            // $transactionDetails['netAmount'] = $details->getSubtotal();
            // return response()->json($transactionDetails);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
