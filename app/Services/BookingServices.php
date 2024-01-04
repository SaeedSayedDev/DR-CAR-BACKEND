<?php

namespace App\Services;

class BookingServices
{
    function updateBooking($booking, $payment_type, $payment_id)
    {
        return  $booking->update(
            [
                'payment_type' => $payment_type,
                'payment_stataus' => 'paid',
                'payment_id' => $payment_id,
            ]
        );
    }
}
