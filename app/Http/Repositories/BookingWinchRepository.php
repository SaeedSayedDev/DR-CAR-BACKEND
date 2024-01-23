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

    public function getBookingForWinch()
    {
        $bookings = BookingWinch::where('garage_id', auth()->user()->id)->with('user.winch_information')
            ->with('address')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $bookings,
            "message" => "Bookings retrieved successfully"

        ]);
    }

    public function bookingWinch($request)
    {
        $user = auth()->user();
        $data = $request->all();
        $bookingService = BookingService::where('user_id', $user->id)
            ->where('order_status_id', '>', 1)->where('order_status_id', '<', 7)
            ->where('cancel', false)
            ->with('service')
            ->findOrFail($data['booking_service_id']);

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



    public function updateBookingStatusFromWinch($request, $booking_id)
    {
        $user = auth()->user();

        DB::beginTransaction();

        $bookingWinch = BookingWinch::where('winch_id', $user->id)->find($booking_id);

        if ($bookingWinch->order_status_id > 2 and $request->order_status_id == 7)
            return response()->json(['message' => 'you can not decline this booking now'], 404);

        $bookingWinch->update(['order_status_id' => $request->order_status_id]);
        $this->notification($bookingWinch->id, auth()->user()->id, auth()->user()->full_name);

        DB::commit();
        return response()->json(['message' => 'success']);
    }




    public function cancelBookingWinchFromUser($booking_id)
    {
        $user = auth()->user();

        DB::beginTransaction();
        $bookingWinch = BookingWinch::where('user_id', $user->id)->where('order_status_id', 1)->where('id', $booking_id)->orWhere('order_status_id', 2)->where('id', $booking_id)->firstOrFail();
        $bookingWinch->update(['cancel' => true]);
        $this->notification($bookingWinch->id, auth()->user()->id, auth()->user()->full_name);

        DB::commit();
        return response()->json(['message' => 'success']);
    }

   



    function notification($booking_id, $reciver_id, $creator_name)
    {

        $text_en = "#$booking_id Booking Status has been changed ";
        $text_ar = "#$booking_id تم تغيير حالة حجز الخدمة ";
        $notification_type_en = "booking";
        $notification_type_ar = "حجز";
        $api =  url("api/booking/show/" . $booking_id);
        $this->notificationService->notification($booking_id, $creator_name,  $text_en, $text_ar, $notification_type_en, $notification_type_ar, $api, $reciver_id);
    }
}
