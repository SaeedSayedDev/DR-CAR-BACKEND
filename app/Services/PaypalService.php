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


    public function success(Request $request)
    {
        try {
            DB::beginTransaction();

            $retrieveOrder = $this->capture_and_retrieve_order($request['token']);

            if (isset($retrieveOrder['status']) and $retrieveOrder['status'] == 'COMPLETED' and $retrieveOrder['payer']['payer_id'] == $request['PayerID']) {

                // $bookingId_or_userId =  $retrieveOrder['purchase_units'][0]['custom_id'] ;    
                // $type =  $retrieveOrder['purchase_units'][0]['soft_descriptor']
                // $net = $retrieveOrder['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value']
                $net_aed = $this->convertCurrencyService->convertAmountFromUSDToAED($retrieveOrder['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value']);
                if ($retrieveOrder['purchase_units'][0]['soft_descriptor'] == 'booking') {

                    $booking_service = BookingService::with('booking_winch')->find($retrieveOrder['purchase_units'][0]['custom_id']);


                    // if ($booking_service->delivery_car == true and isset($booking_service->booking_winch)) {
                    //     $this->booking_service->updateBooking($booking_service->booking_winch, 2, $retrieve->id);
                    //     $this->walletService->updateWallet($booking_service->booking_winch->winch_id, $netDivision['winch_net']);
                    // }
                    $netDivision = $this->bookingService->netDivision($booking_service->delivery_car, $booking_service->payment_amount, $booking_service->booking_winch->payment_amount, $net_aed);

                    if (isset($booking_service->booking_winch) and $booking_service->delivery_car == true) {
                        $this->bookingService->updateBooking($booking_service->booking_winch, 1, $request['token']);
                        $this->walletService->updateWallet($booking_service->booking_winch->winch_id, $netDivision['winch_net'], 'booking', $booking_service->user_id);
                    }

                    $this->bookingService->updateBooking($booking_service, 1, $request['token']);
                    $this->walletService->updateWallet($booking_service->serviceProvider->provider->garage_id, $netDivision['garage_net'], 'booking', $booking_service->user_id);
                } else if ($retrieveOrder['purchase_units'][0]['soft_descriptor'] == 'user')/* wallet == user  */ {
                    $this->walletService->updateWallet($retrieveOrder['purchase_units'][0]['custom_id'], $net_aed, 'charge wallet', $retrieveOrder['purchase_units'][0]['custom_id']);
                }
                DB::commit();

                return response()->json(['message' => 'success']);
            }
            return response()->json(['message' => 'issue in paypal'], 404);
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
}
