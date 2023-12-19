<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\FavouriteInterface;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Service;
use App\Models\BookingService;
use App\Models\Coupon;
use App\Models\Favourite;
use App\Models\User;
use App\Models\Wallet;
use App\Services\BookingServices;
use App\Services\ConvertCurrencyService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;

class BookingServiceRepository implements BookingServiceInterface
{

    public function __construct(private StripeService $stripeService, private PaypalService $paypalService, private BookingServices $bookingService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService)
    {
    }

    public function bookingService($request)
    {
        $service =  Service::where('enable_booking', true)->find($request->service_id);
        if (isset($request->quantity) and $service->price_unit == 1)
            $service_price = $service->discount_price * $request->quantity;
        else
            $service_price = $service->discount_price;

        if (isset($request->coupon)) {
            $coupon = Coupon::where('coupon', $request->coupon)->where('provider_id', $service->provider_id)->first();
            if ($coupon->coupon_unit == 0)
                $service_price = $service_price - $coupon->coupon_price;
            elseif ($coupon->coupon_unit == 1)
                $service_price = $service_price - $coupon->coupon_price / 100 * $service_price;
        }
        $requestData = $request->all();
        $requestData['payment_amount'] = $service_price;
        $requestData['user_id'] = auth()->user()->id;
        BookingService::create($requestData);
        return response()->json(['message' => 'success']);
    }


    public function payBookingSerivice($request, $service_id)
    {
        $user_id = auth()->user()->id;
        $bookingService = BookingService::where('user_id', $user_id)->where('payment_stataus', 'unpaid')->where('service_id', $service_id)->first();
        $payment_method =  PaymentMethod::where('enabled', 1)->where('payment_type', $request->payment_type)->first();

        if (isset($bookingService)) {
            if ($payment_method->name == 'Stripe') {

                $retrieve = $this->payWithStripe($request, $bookingService->payment_amount);

                $this->bookingService->updateBookingService($bookingService, 2, $retrieve->id);

                $this->walletService->updateWallet(auth()->user()->id, $retrieve->balance_transaction->net / 100);

                return response()->json(['message' => 'success']);
            } elseif ($payment_method->name == 'Paypal') {
                $amount_usd = $this->convertCurrencyService->convertAmountFromAEDToUSA($bookingService->payment_amount);

                return  $this->paypalService->createOrder($amount_usd, $bookingService->id, 'booking');
            }
        }
        return response()->json(['message' => 'this booking not found or paid'], 404);
    }

    function payWithStripe($request, $payment_amount)
    {
        $cardData = $this->stripeService->createTokenCard($request->all());
        $charge = $this->stripeService->stripeCharge($cardData->id, $payment_amount);
        $retrieve = $this->stripeService->stripeChargeRetrieve($charge->id);
        return $retrieve;
    }

    public function success($request)
    {
        return $this->paypalService->success($request);
    }
}
