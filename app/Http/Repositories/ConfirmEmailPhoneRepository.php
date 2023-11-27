<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ConfirmEmailPhoneInterface;
use App\Models\User;
use App\Services\OtpService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class ConfirmEmailPhoneRepository implements ConfirmEmailPhoneInterface
{

    private $otpService;
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendCodePhone()
    {
        $validation = Validator::make(request()->all(), [
            'phone' => ['required', 'exists:users,phone'],
        ]);
        if ($validation->fails()) {
            return response($validation->errors(), 404);
        }

        if (isset(request()->phone)) {
            $user = User::where('phone', request()->phone)->first();
            if ($user) {
                return  $this->otpService->createSms();
            } else {
                return  response()->json(['message' => 'this phone is not found'], 404);
            }
        }
    }

    public function confirmCodePhone($request)
    {

        $validation = Validator::make(request()->all(), [
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'exists:users,phone'],
        ]);
        if ($validation->fails()) {
            return response($validation->errors(), 404);
        }

        $user_phone = User::Where('phone', $request->phone)->with('otpUser')->first();

        try {

            /* Get credentials from .env */
            if ($user_phone) {
                return response()->json(['message' => 'This serviec will be added soon'], 401);
            } else {
                return response()->json(['message' => 'this user not found'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function confirmCodeEmail($request)
    {

        $user = User::Where('email', $request->email)->with('otpUser')->first();
        if (!$user)
            return response()->json(['message' => 'this user not found'], 404);

        if ($request->verification_code == $user->otpUser->otp and $user->otpUser->updated_at->addMinutes(10) >= Carbon::now()) {
            $user->update(['email_verified_at' => now()]);
            return response()->json(['message' => 'Email Confirmed']);
        } else {
            return response()->json(['message' => 'This code is not correct or expire'], 401);
        }
    }
}
