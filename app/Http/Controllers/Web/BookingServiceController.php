<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\BookingServiceInterface;

class BookingServiceController extends Controller
{
    public function __construct(private BookingServiceInterface $bookingServiceInterface)
    {
    }

    public function __invoke()
    {
        return $this->bookingServiceInterface->index();
    }
}
