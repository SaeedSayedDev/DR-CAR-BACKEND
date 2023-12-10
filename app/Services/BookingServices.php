<?php

namespace App\Services;

class BookingServices
{
    function updateBookingService($bookingService, $payment_type, $payment_id)
    {
        return  $bookingService->update(
            [
                'payment_type' => $payment_type,
                'payment_stataus' => 'paid',
                'payment_id' => $payment_id,
            ]
        );
    }
}
