<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BookingServiceInterface;
use App\Http\Interfaces\FavouriteInterface;
use App\Models\Address;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Service;
use App\Models\BookingService;
use App\Models\BookingWinch;
use App\Models\Coupon;
use App\Models\Wallet;
use App\Services\BookingServices;
use App\Services\BookingWinchService;
use App\Services\ConvertCurrencyService;
use App\Services\ImageService;
use App\Services\NotificationService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;

class BookingServiceRepository implements BookingServiceInterface
{

    public function __construct(private StripeService $stripeService, private PaypalService $paypalService, private BookingServices $bookingService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService, private NotificationService $notificationService, private ImageService $imageService)
    {
    }


    /////////////////// booking in user /////////////////////

    public function getBookingsInUser($filter_key)
    {
        $bookingsGarage = BookingService::where('user_id', auth()->user()->id)->with('service.media', 'service.provider:id,name')
            ->with('user.addressUser')
            ->where('order_status_id', $filter_key)
            ->get();
        $bookingsWinch = BookingWinch::where('user_id', auth()->user()->id)->with('user.user_information', 'winch.winch_information')
            ->with('user.addressUser')
            ->where('order_status_id', $filter_key)
            ->get();
        $bookings = collect($bookingsGarage->toArray())->merge($bookingsWinch->toArray());
        $sortedBookings = $bookings->sortBy('created_at');


        return response()->json([
            'success' => true,
            'data' => $sortedBookings,
            "message" => "Bookings retrieved successfully"

        ]);
    }


    public function bookingService($request)
    {
        $service =  Service::where('enable_booking', true)->findOrFail($request->service_id);
        $service_price = $this->bookingService->priceBooking($request, $service);
        $service_price_plus_commission = $this->bookingService->commissionForPayment($service_price);
        $bookingData = $this->bookingService->bookingData($request, $service_price_plus_commission);
        // $this->bookingService->addressBooking($request);
        $this->notification($bookingData->id, $bookingData->service->provider->garage_id, auth()->user()->full_name);

        return response()->json([
            'success' => true,
            'data' => $bookingData,
            "message" => "Bookings retrieved successfully"
        ]);
    }


    public function payBookingSerivice($request, $booking_service_id)
    {
        $user_id = auth()->user()->id;

        $bookingService = BookingService::where('user_id', $user_id)
            ->with('booking_winch')
            ->with('serviceProvider.provider')
            ->where('payment_stataus', 'unpaid')
            ->where('order_status_id', 4)
            ->where('cancel', false)
            ->findOrFail($booking_service_id);

        if ($bookingService->delivery_car == 1 and !isset($bookingService->booking_winch))
            return response()->json(['message' => 'you should booking winch'], 404);
        $total_amount = $bookingService->booking_winch ? $bookingService->booking_winch->payment_amount + $bookingService->payment_amount : $bookingService->payment_amount;


        $payment_method =  PaymentMethod::where('enabled', 1)->where('payment_type', $request->payment_type)->firstOrFail();

        DB::beginTransaction();
        if ($payment_method->name == 'Stripe') {
            $retrieve = $this->payWithStripe($request, $total_amount);
            return  $this->stripeService->payWithStripe($request, $bookingService, $total_amount, $retrieve);
        } elseif ($payment_method->name == 'Paypal') {
            $amount_usd = $this->convertCurrencyService->convertAmountFromAEDToUSA($total_amount);

            return  $this->paypalService->createOrder($amount_usd, $bookingService->id, 'booking');
        } else if ($payment_method->name == 'Wallet') {

            return  $this->walletService->payWithWallet($request, $bookingService, $total_amount);
        }
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

    public function cancelBooking($booking_id)
    {
        DB::beginTransaction();

        $bookingService = BookingService::where('user_id', auth()->user()->id)->where('order_status_id', '<', 3)->findOrFail($booking_id);
        $bookingService->update(['cancel' => true, 'order_status_id' => 7]);
        $this->notification($bookingService->id,  $bookingService->service->provider->garage_id, auth()->user()->full_name);

        DB::commit();

        return response()->json(['message' => 'success']);
    }

    public function onTheWayFromUser($booking_id)
    {
        DB::beginTransaction();

        $bookingService = BookingService::where('user_id', auth()->user()->id)->where('order_status_id', 2)->where('delivery_car', 0)->findOrFail($booking_id);

        $bookingService->update(['order_status_id' => 3]);
        $this->notification($bookingService->id,  $bookingService->service->provider->garage_id, auth()->user()->full_name);

        DB::commit();

        return response()->json(['message' => 'success']);
    }


    /////////////////// booking in garage /////////////////////

    public function getBookingsInGarage($filter_key)
    {
        if (isset(auth()->user()->garage_data)) {
            $bookings = BookingService::whereHas('serviceProvider', function ($query) {
                $query->where('provider_id', auth()->user()->garage_data->id);
            })
                ->with('serviceProvider.media', 'serviceProvider.provider', 'user.address', 'media')
                ->where('order_status_id', $filter_key)
                ->get();
            return response()->json([
                'success' => true,
                'data' => $bookings,
                "message" => "Bookings retrieved successfully"

            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "please create garage data"
        ]);
    }



    public function showBooking($booking_id)
    {
        if (isset(auth()->user()->garage_data)) {
            $bookingService = BookingService::with('booking_winch_in_show_bookingService')->whereHas('serviceProvider', function ($query) {
                $query->where('provider_id', auth()->user()->garage_data->id);
            })
                ->with(['service.media', 'service.options', 'user.addressUser', 'status_order', 'media'])
                ->findOrFail($booking_id);
        } else {

            $bookingService = BookingService::with('booking_winch_in_show_bookingService')->WhereHas('user')->with('user.user_information')->where('user_id', auth()->user()->id)
                ->with(['service.media', 'service.options', 'user.addressUser', 'status_order', 'media'])
                ->findOrFail($booking_id);
            // $bookingService->user_information->where('user_id', $bookingService->user_id);
        }
        $payment_amount_usd = $this->convertCurrencyService->convertAmountFromAEDToUSA($bookingService->payment_amount);


        if ($bookingService->booking_winch_in_show_bookingService === null)
            $bookingService->isset_bookingWinch_in_bookingService = 0;
        else
            $bookingService->isset_bookingWinch_in_bookingService = 1;
        unset($bookingService->booking_winch_in_show_bookingService);

        $bookingService->payment = [
            'payment_status' => $bookingService->payment_stataus,
            'payment_amount' =>  $bookingService->payment_amount,
            'payment_amount_usd' => $payment_amount_usd,
            'payment_type' =>  $bookingService->payment_type,
            'payment_id' => $bookingService->payment_id,
            // 'payment_method' => $bookingService->payment_id

        ];
        unset($bookingService->payment_stataus, $bookingService->payment_amount, $bookingService->payment_type, $bookingService->payment_id);
        return response()->json([
            'success' => true,
            'data' => $bookingService,
            "message" => "Bookings retrieved successfully"

        ]);
    }



    public function updateBookingServiceFromGarage($request, $booking_id)
    {
        DB::beginTransaction();
        if ($request->order_status_id == 3)
            return response()->json(['message' => 'this status updated from user'], 404);

        $bookingService = BookingService::whereHas('serviceProvider', function ($query) {
            $query->where('provider_id', auth()->user()->garage_data->id);
        })
            ->with('serviceProvider.media', 'serviceProvider:id,name')->findOrFail($booking_id);

        if ($bookingService->order_status_id > 2 and $request->order_status_id == 7)
            return response()->json(['message' => 'you can not decline this booking now'], 404);

        if (
            $bookingService->delivery_car == 1 and $request->order_status_id != 2 and
            ($bookingService->booking_winch and $bookingService->booking_winch->order_status_id < 3 or !$bookingService->booking_winch)
        ) {
            return response()->json(['message' => 'you can not update this booking now, you should booking winch and and status winch should be accepted']);
        }

        $bookingService->update(['order_status_id' => $request->order_status_id]);
        if ($request->order_status_id == 4) {
            $request['images'] = [
                0 => $request->image_front,
                1 => $request->image_back,
                2 => $request->image_right_side,
                3 => $request->image_left_side,
            ];
            // return $request->images;
            $this->imageService->storeMedia($request, $bookingService->id, 'garage_receive', 'public/images/admin/receives', url("api/images/Receive/"));
        }

        $this->notification($bookingService->id, $bookingService->user_id, auth()->user()->full_name);
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
