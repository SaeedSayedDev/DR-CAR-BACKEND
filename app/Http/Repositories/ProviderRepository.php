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
        $garage = GarageData::with('user.media')->with('services.media')->get();
        return response()->json([
            'data' => $garage,
        ]);
    }
    public function show($id)
    {

        $garage = GarageData::with('user.media')->with('services.media')->findOrFail($id);
        // $user->with(match ($user->role_id) {
        //     3 => 'winch_information',
        //     4 => 'garage_information',
        // });


        return response()->json([
            'data' => $garage,
        ]);
    }
}
