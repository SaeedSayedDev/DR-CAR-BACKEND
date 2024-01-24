<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\BookingWinchInterface;

class BookingWinchController extends Controller
{
    public function __construct(private BookingWinchInterface $bookingWinchInterface)
    {
    }

    public function __invoke()
    {
        return $this->bookingWinchInterface->index();
    }
}
