<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\PasswordInterface;
use App\Http\Interfaces\ProviderInterface;
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

    public function show($id)
    {

        $user = User::where('role_id', 3)->orWhere('role_id', 4)->with('services.media')->with('media')->findOrFail($id);
        $user->with(match ($user->role_id) {
            3 => 'winch_information',
            4 => 'garage_information',
        });


        return response()->json([
            'data' => $user,

        ]);
    }
}
