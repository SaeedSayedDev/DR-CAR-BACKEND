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
        try {
            $data['email'] = $email;
            $data['title'] = "Dr.car";
            $data['otp'] = rand(100000, 999999);

            // $this->SendMailService->getInfoMailConfig();
            Mail::send('sendEmailOtp', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
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
        } catch (Exception $e) {
            return  response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
