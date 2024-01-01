<?php

namespace App\Http\Controllers;

use App\Models\FirbaseToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    //
    public function artisanOrder(Request $request)
    {
        $status = Artisan::call($request->order);
        return response()->json([$request['order'] => 'success', 'status' => $status]);
    }
    public function testNotification()
    {
        //user booked employee ,we should send notification to employeeُ s company 
        // $user = auth()->user();

        $firebaseTokens = ['fVWQpAkjyyzl2ARX2w8ERZ:APA91bGYEms0s35MSbFtuTLtDiQ6R_mkQIh2dr3kFi5hlXVPm-vec71sWDHYnKlCL4snoKX_ItS46JPzBgqvMTme5Swsjf9T6Tdk-O43l9jxm5wUriNJxcSV4-6RCzCGTPJh90xdBNo0'];
        $body = [
            'type_id' => 1,
            'creator_name' => 'test noti',
            'user_id' => 2,
            'notification_type_en' => 'notification en',
            'notification_type_ar' => 'اشعار عربية',
            'text_en' => 'text en',
            'text_ar' => 'كلمات عربية',
            'api' => 'api_test',
        ];
        DB::beginTransaction();
        $Firbase_API_KEY = 'AAAAbOBP3Tg:APA91bG4xtId8xJneVeIq3ThmAKhKkm7U3VyHoTlgK0J_R238FyEKQ1y36LzN0rZsrXrighQX7IvBY3VJ1_yPHPOVpUDPP9JrBLSFZeb3fAu-aEvU5I6M_VjxoT0xq26dNsmaDQAIADe';

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
    // public function Dotenv()
    // {
    //     dd(Dotenv\Dotenv::createArrayBacked(base_path())->load());
    // }
}
