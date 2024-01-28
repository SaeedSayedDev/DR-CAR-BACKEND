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
use App\Services\BookingServices;
use App\Services\BookingWinchService;
use App\Services\ConvertCurrencyService;
use App\Services\NotificationService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;

class BookingServiceRepository implements BookingServiceInterface
{

    public function __construct(private StripeService $stripeService, private PaypalService $paypalService, private BookingServices $bookingService, private WalletService $walletService, private ConvertCurrencyService $convertCurrencyService, private NotificationService $notificationService)
    {
    }


    /////////////////// booking in user /////////////////////

    public function getBookingsInUser($filter_key)
    {
        $bookingsGarage = BookingService::where('user_id', auth()->user()->id)->with('service.media', 'service.provider:id,name')
            ->with('address')
            ->where('order_status_id', $filter_key)
            ->get();

        $bookingsWinch = BookingWinch::where('user_id', auth()->user()->id)->with('user.user_information', 'winch.winch_information')
            ->with('address')
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

        $this->bookingService->addressBooking($request);
        $this->notification($bookingData->id, auth()->user()->id, auth()->user()->full_name);

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
            ->where('order_status_id', 6)
            ->where('cancel', false)
            ->find($booking_service_id);
        if ($bookingService->delivery_car == 1 and !isset($bookingService->booking_winch))
            return response()->json(['message' => 'you should booking winch'], 404);
        $total_amount = $bookingService->booking_winch ? $bookingService->booking_winch->payment_amount + $bookingService->payment_amount : $bookingService->payment_amount;


        $payment_method =  PaymentMethod::where('enabled', 1)->where('payment_type', $request->payment_type)->firstOrFail();
        if ($payment_method->name == 'Stripe') {

            $retrieve = $this->payWithStripe($request, $total_amount);
            $netDivision = $this->bookingService->netDivision($bookingService->delivery_car, $bookingService->payment_amount, $bookingService->booking_winch->payment_amount, $retrieve->balance_transaction->net / 100);

            if ($bookingService->delivery_car == true and isset($bookingService->booking_winch)) {
                $this->bookingService->updateBooking($bookingService->booking_winch, 2, $retrieve->id);
                $winchNetAfterCommission = $this->bookingService->commissionNet($bookingService->booking_winch->payment_amount, $netDivision['winch_net']);

                $this->walletService->updateWallet($bookingService->booking_winch->winch_id, $winchNetAfterCommission, 'booking', $bookingService->user_id);
            }
            $garageNetAfterCommission = $this->bookingService->commissionNet($bookingService->payment_amount, $netDivision['garage_net']);

            $this->bookingService->updateBooking($bookingService, 2, $retrieve->id);
            $this->walletService->updateWallet($bookingService->serviceProvider->provider->garage_id, $garageNetAfterCommission, 'booking', $bookingService->user_id);


            return response()->json(['message' => 'success']);
        } elseif ($payment_method->name == 'Paypal') {
            $amount_usd = $this->convertCurrencyService->convertAmountFromAEDToUSA($total_amount);

            return  $this->paypalService->createOrder($amount_usd, $bookingService->id, 'booking');
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

        $bookingService->update(['cancel' => true]);
        $this->notification($bookingService->id, auth()->user()->id, auth()->user()->full_name);

        DB::commit();

        return response()->json(['message' => 'success']);
    }




    /////////////////// booking in garage /////////////////////

    public function getBookingsInGarage($filter_key)
    {
        $bookings = BookingService::whereHas('serviceProvider', function ($query) {
            $query->where('provider_id', auth()->user()->garage_data->id);
        })
            ->with('serviceProvider.media', 'serviceProvider.provider')
            ->where('order_status_id', $filter_key)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $bookings,
            "message" => "Bookings retrieved successfully"

        ]);
    }



    public function showBooking($booking_id)
    {
        // dd(auth()->user()->user_information);
        if (isset(auth()->user()->garage_data)) {
            $bookingService = BookingService::whereHas('serviceProvider', function ($query) {
                $query->where('provider_id', auth()->user()->garage_data->id);
            })
                // ->orWhereHas('user')->where('user_id', auth()->user()->id)
                ->with(['service.media', 'service.options', 'address', 'status_order'])
                ->findOrFail($booking_id);
        } else {
            
            $bookingService = BookingService::WhereHas('user')->with('user.user_information')->where('user_id', auth()->user()->id)
                ->with(['service.media', 'service.options', 'address', 'status_order'])
                ->findOrFail($booking_id);
                // $bookingService->user_information->where('user_id', $bookingService->user_id);
        }
        $bookingService->payment = [
            'payment_status' => $bookingService->payment_stataus,
            'payment_amount' =>  $bookingService->payment_amount,
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
        $bookingService = BookingService::whereHas('serviceProvider', function ($query) {
            $query->where('provider_id', auth()->user()->garage_data->id);
        })
            ->with('serviceProvider.media', 'serviceProvider:id,name')->findOrFail($booking_id);

        if ($bookingService->order_status_id > 2 and $request->order_status_id == 7)
            return response()->json(['message' => 'you can not decline this booking now'], 404);

        $bookingService->update(['order_status_id' => $request->order_status_id]);

        $this->notification($bookingService->id, auth()->user()->id, auth()->user()->full_name);
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
