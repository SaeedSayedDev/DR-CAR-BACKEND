<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\BookingWinchInterface;
use App\Http\Interfaces\FavouriteInterface;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Service;
use App\Models\BookingService;
use App\Models\BookingWinch;
use App\Models\Coupon;
use App\Models\WinchInformation;
use App\Services\AddressService;
use App\Services\BookingServices;
use App\Services\ConvertCurrencyService;
use App\Services\NotificationService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;

class BookingWinchRepository implements BookingWinchInterface
{

    public function __construct(private StripeService $stripeService, private PaypalService $paypalService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService, private NotificationService $notificationService, private AddressService $addressService)
    {
    }


    public function bookingWinch($request)
    {
        $user = auth()->user();
        $data = $request->all();
        $bookingService = BookingService::where('user_id', $user->id)
            ->where('order_status_id', '>', 1)->where('order_status_id', '<', 6)
            ->where('cancel', false)
            ->with('service')
            ->find($data['booking_service_id']);

        $range = $this->addressService->calculate_range_beetwen_user_and_garage($bookingService->service->provider_id);

        $WinchInformation = WinchInformation::where('winch_id', $data['winch_id'])->first();
        $data['payment_amount'] = $range * $WinchInformation->KM_price;
        $data['user_id'] = $user->id;

        $bookingWinch = BookingWinch::create($data);

        return response()->json([
            'success' => true,
            'data' => $bookingWinch,
            "message" => "Booking Winch retrieved successfully"
        ]);
    }
}
