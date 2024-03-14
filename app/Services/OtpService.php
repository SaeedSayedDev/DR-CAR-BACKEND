<?php

namespace App\Services;

use App\Models\MultiAuthUser;
use App\Models\OtpUser;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Config;


class OtpService
{
    // private $SendMailService;

    // public function __construct(SendEmailService $SendMailService,)
    // {

    //     $this->SendMailService = $SendMailService;
    // }
    public function createSms()
    {
        //code whene link with service
        return response()->json(['message' => 'This service will be added soon'], 404);
    }
    public function createEmail($email, $user_id, $type_user)
    {
        $data['title'] = "Dr.car";
        $data['otp'] = rand(100000, 999999);

        Mail::send('sendEmailOtp',  ['otp' => $data['otp']], function ($message) use ($data, $email) {
            $message->from('support@drcar.me', 'DRCAR');
            $message->to($email)->subject($data['title']);
        });

        OtpUser::updateOrCreate(
            [
                'user_id' => $user_id,
                'type_user' => $type_user
            ],
            [
                'otp' => $data['otp'],
                'type_user' => $type_user
            ]
        );
        return response()->json(['message' => 'please check your email']);
    }
}
