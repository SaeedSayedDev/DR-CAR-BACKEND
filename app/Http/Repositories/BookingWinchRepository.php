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
use App\Models\User;
use App\Models\WinchInformation;
use App\Services\AddressService;
use App\Services\BookingServices;
use App\Services\ConvertCurrencyService;
use App\Services\ImageService;
use App\Services\NotificationService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;

class BookingWinchRepository implements BookingWinchInterface
{

    public function __construct(private StripeService $stripeService, private PaypalService $paypalService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService, private NotificationService $notificationService, private AddressService $addressService, private ImageService $imageService)
    {
    }

    public function getWinchsInUser()
    {
        // return auth()->user();
        $userLatitude = auth()->user()->address[0]['latitude'];
        $userLongitude = auth()->user()->address[0]['longitude'];
        $winchs = User::where('role_id', 3)->whereHas('avilabilty_range')
            ->whereHas('winch_information', function ($q) {
                $q->where('available_now', 1);
            })
            ->with('address', 'media', 'winch_information')->get();
        // ->map(function ($winch) {
        //     if (isset(auth()->user()->address[0]) and isset($winch->address)) {
        //         $distance = $this->addressService->calDistance($winch->address[0]->latitude, $winch->address[0]->longitude, auth()->user()->address[0]->latitude, auth()->user()->address[0]->longitude);

        //         if ($distance > $winch->availability_range) {
        //             unset($winch);
        //             return;
        //         }

        //         return  $winch;
        //     }
        //     return;
        // });
        return ['data' => $winchs];
    }


    public function getBookingForWinch($filter_key)
    {
        $bookings = BookingWinch::where('winch_id', auth()->user()->id)->with('user.winch_information')
            ->with('address', 'media')
            ->where('order_status_id', $filter_key)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $bookings,
            "message" => "Bookings retrieved successfully"
        ]);
    }

    public function showBookingWinch($booking_id)
    {
        $user = auth()->user();

        $bookingWinch = BookingWinch::with('user.user_information', 'media')
            ->with('user.address')
            ->with('user.media')
            ->with('winch.winch_information')
            ->with('winch.media')
            ->where('user_id', $user->id)
            ->orWhere('winch_id', $user->id)
            ->findOrFail($booking_id);

        $payment_amount_usd = $this->convertCurrencyService->convertAmountFromAEDToUSA($bookingWinch->payment_amount);

        $bookingWinch->payment = [
            'payment_status' => $bookingWinch->payment_stataus,
            'payment_amount' =>  $bookingWinch->payment_amount,
            'payment_amount_usd' =>  $payment_amount_usd,
            'payment_type' =>  $bookingWinch->payment_type,
            'payment_id' => $bookingWinch->payment_id,
        ];
        unset($bookingWinch->payment_stataus, $bookingWinch->payment_amount, $bookingWinch->payment_type, $bookingWinch->payment_id);
        return response()->json([
            'success' => true,
            'data' => $bookingWinch,
            "message" => "Bookings retrieved successfully"

        ]);
    }

    public function bookingWinch($request)
    {
        $user = auth()->user();
        $data = $request->all();
        $bookingService = BookingService::where('user_id', $user->id)
            ->where('order_status_id', 2)
            ->where('cancel', false)
            ->with('service')
            ->where('delivery_car', 1)
            ->findOrFail($data['booking_service_id']);

        $distance = $this->addressService->calDistance($bookingService->service->provider->address->latitude, $bookingService->service->provider->address->longitude, auth()->user()->address[0]->latitude, auth()->user()->address[0]->longitude);


        $WinchInformation = WinchInformation::where('winch_id', $data['winch_id'])->first();
        $data['payment_amount'] = $distance * $WinchInformation->KM_price;
        $data['user_id'] = $user->id;

        $bookingWinch = BookingWinch::create($data);
        $this->notification($bookingWinch->id, $bookingWinch->winch_id, auth()->user()->full_name);

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

        $bookingWinch = BookingWinch::where('winch_id', $user->id)->findOrFail($booking_id);

        if ($bookingWinch->order_status_id > 2 and $request->order_status_id == 7)
            return response()->json(['message' => 'you can not decline this booking now'], 404);

        $bookingWinch->update(['order_status_id' => $request->order_status_id]);

        if ($request->order_status_id == 4) {
            BookingService::findOrFail($bookingWinch->booking_service_id)->update(['order_status_id' => 3]);


            $request['images'] = [
                0 => $request->image_front,
                1 => $request->image_back,
                2 => $request->image_right_side,
                3 => $request->image_left_side,
            ];
            // return $request->images;
            $this->imageService->storeMedia($request, $bookingWinch->id, 'winch_receive', 'public/images/admin/receives', url("api/images/Receive/"));
        }
        $this->notification($bookingWinch->id,  $bookingWinch->user_id, auth()->user()->full_name);

        DB::commit();
        return response()->json(['message' => 'success']);
    }




    public function cancelBookingWinchFromUser($booking_id)
    {
        $user = auth()->user();

        DB::beginTransaction();
        $bookingWinch = BookingWinch::where('user_id', $user->id)->where('order_status_id', 1)->where('id', $booking_id)->orWhere('order_status_id', 2)->where('id', $booking_id)->firstOrFail();
        $bookingWinch->update(['cancel' => true, 'order_status_id' => 7]);
        $this->notification($bookingWinch->id, $bookingWinch->winch_id, auth()->user()->full_name);

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
