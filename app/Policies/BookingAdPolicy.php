<?php

namespace App\Policies;

use App\Models\BookingAd;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingAdPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function view(User $user, BookingAd $bookingAd)
    {
        return $user->id === $bookingAd->garage_id;
    }

    public function update(User $user, BookingAd $bookingAd)
    {
        return $user->id === $bookingAd->garage_id;
    }

    public function delete(User $user, BookingAd $bookingAd)
    {
        return $user->id === $bookingAd->garage_id;
    }
}
