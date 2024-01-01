<?php

namespace App\Services;

use App\Models\FirbaseToken;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    //type => employee , company , user

    public function notification($type_id, $type_name, $text_en, $text_ar, $notification_type_en, $notification_type_ar, $api, $reciver_id)
    {
        $firebaseTokens = FirbaseToken::where('user_type', false)->where('user_id', $reciver_id)->pluck('fcsToken')->all();
        $body = [
            'type_id' => $type_id,
            'creator_name' => $type_name,
            'user_id' => $reciver_id,
            'notification_type_en' => $notification_type_en,
            'notification_type_ar' => $notification_type_ar,
            'text_en' => $text_en,
            'text_ar' => $text_ar,
            'api' => $api,
        ];
        DB::beginTransaction();
        Notification::create($body);
        $Firbase_API_KEY = 'AAAApDyvbxM:APA91bHGAjidipN5FLe0jp04umD41cZwSXOg8wTlTCDN55wOeQ7HtaO7NoVXsg7D9GT8A1VXdgkNOYzXI_xPpK9goXAFAxNSbpUeT9wxE0iuHiEuV2DDkmScLY2XPqmlb4A3_4CmE1Jd';

        $data = [
            "registration_ids" => $firebaseTokens,
            "notification" => [
                'title' => [
                    'en' => $body['notification_type_en'], // English title
                    'ar' => $body['notification_type_ar'] // Arabic title
                ],
                'body' => [
                    'en' => $body['text_en'], // English body
                    'ar' => $body['text_ar'] // Arabic body
                ]
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $Firbase_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);
        DB::commit();
        // event(new NotificationEvent($user->id));
        // event(new NotificationEvent($employee->company->id));
        return response()->json(['message' => 'Good Test Real Time Notification']);
    }
}
