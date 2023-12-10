<?php

namespace App\Services;

use App\Models\BookingService;
use App\Services\BookingServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Omnipay\Omnipay;

class PaypalService
{
    private $client_id;
    private $secret_id;

    public function __construct(private BookingServices $bookingService, private WalletService $walletService)
    {
        $this->client_id = env('PAYPAL_CLIENT_ID');
        $this->secret_id = env('PAYPAL_CLIENT_SECRET');
    }
    public function createOrder($amount, $booking_id)
    {
        try {
            $data = $this->data($amount, $booking_id);

            $res = Http::withBasicAuth($this->client_id, $this->secret_id)
                ->post(
                    'https://api-m.paypal.com/v2/checkout/orders',
                    $data
                );
            return response()->json(['message' => $res['links'][1]['href']]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }


    function data($amount, $booking_id)
    {
        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => "$amount" // Amount for the order
                    ],
                    "custom_id" => "$booking_id"
                ]
            ],
            'application_context' => [
                'return_url' => 'http://127.0.0.1:8000/success',
                'cancel_url' => 'http://127.0.0.1:8000/error'
            ]
        ];
    }

    public function success(Request $request)
    {
        try {
            $order = Http::withBasicAuth($this->client_id, $this->secret_id)
                ->get('https://api-m.paypal.com/v2/checkout/orders/' . $request->query('token'));


            if ($order && $order['payer']['payer_id'] == $request->input('PayerID')) {

                $booking_service = BookingService::find($order['purchase_units'][0]['custom_id']);

                $this->bookingService->updateBookingService($booking_service, 1, $request->query('token'));

                $this->walletService->updateWallet($booking_service->user_id, $order['purchase_units'][0]['amount']['value']);

                return response()->json(['message' => 'success']);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
