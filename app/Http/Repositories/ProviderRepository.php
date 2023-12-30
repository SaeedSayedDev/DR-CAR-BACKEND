<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\PasswordInterface;
use App\Http\Interfaces\ProviderInterface;
use App\Models\GarageData;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\OtpService;
use App\Services\PasswordService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProviderRepository implements ProviderInterface
{
    public function index()
    {
        $garage = GarageData::with('user.media')->with('user.garage_information')->with('services.media')->with('address')->get();
        return response()->json([
            'data' => $garage,
        ]);
    }
    public function show($id)
    {

        $garage = GarageData::with(['user:id,email', 'user.media', 'user.garage_information'])->with('services', function ($q) {
            $q->with('media')->with('review')->withSum('review', 'review_value')->withCount('review');
        })->with(['availabilityTime', 'taxe', 'address'])->findOrFail($id);

        $garage->user->phone = $garage->user->garage_information->phone_number;
        $garage->user->short_biography = $garage->user->garage_information->short_biography;
        $garage->review = $garage->services->sum('review_count');
        $garage->rate = $garage->services->sum('review_sum_review_value') /  $garage->review;
        unset($garage->user->garage_information);

        return response()->json([
            'data' => $garage,
        ]);
    }
}
