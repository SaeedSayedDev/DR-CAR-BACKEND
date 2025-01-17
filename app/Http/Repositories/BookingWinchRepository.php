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
        if (!isset(auth()->user()->address[0]))
            return response()->json([
                "message" => "please create address first"
            ]);
        $userLatitude = auth()->user()->address[0]['latitude'];
        $userLongitude = auth()->user()->address[0]['longitude'];
        $winchs = User::where('role_id', 3)
            ->where('ban', 0)
            ->join('winch_information', 'winch_information.winch_id', '=', 'users.id')
            ->join('addresses', 'addresses.user_id', '=', 'users.id')
            ->leftJoin('booking_winches', 'booking_winches.winch_id', '=', 'users.id')->select('booking_winches.*', 'users.*')->with(['bookingsWinch.bookingService'])
            // ->select('users.id', 'winch_information.phone_number', 'addresses.latitude')
            ->whereRaw("latitude BETWEEN (? - winch_information.availability_range) AND (? + winch_information.availability_range)", [$userLatitude, $userLatitude])
            ->whereRaw("longitude BETWEEN (? - winch_information.availability_range) AND (? + winch_information.availability_range)", [$userLongitude, $userLongitude])
            ->with('winch_information', 'address', 'media', 'bookingsWinch')
            ->whereHas('winch_information', function ($q) {
                $q->where('available_now', 1);
            })
            ->get()->map(function ($winch) {
                foreach ($winch->bookingsWinch as $bookingWinch) {
                    if ($bookingWinch->order_status_id > 1 and $bookingWinch->order_status_id < 6) {
                        if ($bookingWinch->round_trip == 0)
                            return null;
                        else if (
                            $bookingWinch->round_trip == 1
                            and $bookingWinch->bookingService->order_status_id == 6
                            and $bookingWinch->order_status_id != 6
                        )
                            return null;
                    }
                }


                return $winch;
            });
        return ['data' => $winchs];
    }


    public function getBookingForWinch($filter_key)
    {
        $bookings = BookingWinch::where('winch_id', auth()->user()->id)
            ->with('address', 'media')
            ->where('order_status_id', $filter_key)
            ->with("user.user_information")
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
            ->with('address')
            ->with('user.media')
            ->with('winch.winch_information')
            ->with('winch.media')
            ->with('status_order')
            ->with('winch.addressUser')
            ->where('user_id', $user->id)
            ->where('id', $booking_id)
            ->orWhere('winch_id', $user->id)
            ->where('id', $booking_id)
            ->firstOrFail();

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
            ->with('booking_winch_in_show_bookingService')
            ->findOrFail($data['booking_service_id']);
        if (!isset($bookingService->service->provider->address))
            return response()->json(["message" => "garage has not address"]);


        if (!$bookingService->booking_winch_in_show_bookingService) {

            $check_winch_has_booking =  BookingWinch::where('winch_id', $data['winch_id'])->where('order_status_id', '>', '1')->where('order_status_id', '<', '6')->with('bookingService')->first();
            if (isset($check_winch_has_booking) and $check_winch_has_booking->round_trip == 0)
                return response()->json(["message" => "please choose another winch"]);
            else if (
                isset($check_winch_has_booking) and $check_winch_has_booking->round_trip == 1
                and $check_winch_has_booking->bookingService->order_status_id == 6
                and $check_winch_has_booking->order_status_id != 6
            )
                return response()->json(["message" => "please choose another winch"]);

            $distance = $this->addressService->calDistance(
                number_format($bookingService->service->provider->address->latitude, 10, '.', ''),
                number_format($bookingService->service->provider->address->longitude, 10, '.', ''),
                number_format(auth()->user()->address[0]->latitude, 10, '.', ''),
                number_format(auth()->user()->address[0]->longitude, 10, '.', ''),
            );
            $data['address_id'] = $bookingService->address_id;
            $WinchInformation = WinchInformation::where('winch_id', $data['winch_id'])->first();
            $data['payment_amount'] = number_format($distance * $WinchInformation->KM_price, 2, '.', '');
            if ($request->round_trip == 1)
                $data['payment_amount'] = $data['payment_amount'] * 2;
            $data['user_id'] = $user->id;

            $bookingWinch = BookingWinch::create($data);
            $this->notification($bookingWinch->id, $bookingWinch->winch_id, auth()->user()->full_name);

            return response()->json([
                'success' => true,
                'data' => $bookingWinch,
                "message" => "Booking Winch retrieved successfully"
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "You have already one booking winch, cancel it first to can booking new winch"
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


    public function doneStatusFromUser($booking_id)
    {
        DB::beginTransaction();

        $bookingWinch = BookingWinch::where('user_id', auth()->user()->id)->where('order_status_id', 5)->findOrFail($booking_id);

        $bookingWinch->update(['order_status_id' => 6]);
        $this->notification($bookingWinch->id,  $bookingWinch->winch_id, auth()->user()->full_name);

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
        $api =  url("api/booking/winch/show/" . $booking_id);
        $this->notificationService->notification($booking_id, $creator_name,  $text_en, $text_ar, $notification_type_en, $notification_type_ar, $api, $reciver_id);
    }
}
