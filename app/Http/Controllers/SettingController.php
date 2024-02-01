<?php

namespace App\Http\Controllers;

use App\Models\FirbaseToken;
use App\Models\TestPaypal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\PaymentList;


class SettingController extends Controller
{
    //
    public function artisanOrder(Request $request)
    {
        $status = Artisan::call($request->order);
        return response()->json([$request['order'] => 'success', 'status' => $status]);
    }
    public function testPaypal()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'ATvM3mEtUPKHBfv8ySMMKVyq09KCKrc0l-5e3S3_KIgbgV17RMKc4L8D30sPHGsImt2FBDYgOmkhzfZ5', #clientId
                'EI3TdIu9pd165ljeVOQlZjRHgV9PLRUSs9wGjf3GJpJuQMbt4aRdkiLFJiIhngf-P_I1oPw4SS573Uc1' #secretKey
            )
        );
        $transactionId = 'PAYID-MW5KTLA8WU55766UR388811Y';

        // Set the PayPal API context
        $apiContext->setConfig([
            'mode' => 'sandbox', // Change to 'live' for production
        ]);

        try {
            // Retrieve the payment details using the transaction ID
            $payment = Payment::get($transactionId, $apiContext);

            // Access details from the $payment object
            $transactionDetails = [
                'id' => $payment->getId(),
                'amount' => $payment->getTransactions()[0]->getAmount()->getTotal(),
                'fees' => $payment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getTransactionFee()->getValue(),
                'customId' => $payment->getTransactions()[0]->getCustom(),
                'softDescriptor' => $payment->getTransactions()[0]->getSoftDescriptor(),
                'status' => $payment->getState(), // or $payment->getIntent() for the payment intent
                'payerId' => $payment->getPayer()->getPayerInfo()->getPayerId(),
                // 'netAmount' => $payment->getTransactions()[0]->getAmount()->getDetails()->getNetAmححount()


            ];
            $details = $payment->getTransactions()[0]->getAmount()->getDetails();
            $transactionDetails['netAmount'] = $details->getSubtotal();
            return response()->json($transactionDetails);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function testNotification()
    {
        //user booked employee ,we should send notification to employeeُ s company 
        // $user = auth()->user();
        // $firebaseTokens = ['ekCAc2JbGGc5GP6mFiPJnz:APA91bFWqktUZUFZfkMh15vBdsbNxGZsbSzctaCEnCR__s09-l4gwaTL44cmF4QMVMamDuP6ckPuGJAgbpzTqf95Tj7rJ-w_ABiuCgsWnvoLwDLV7talyDYH9bAn6X6ZF-A1vu9a0YIx'];

        $firebaseTokens = ['cI2Jh9lqUERtzQKqMyYFyV:APA91bGa1Avjde8HLC2c1E4hgvQlQhOuuDbf0oz6JGv2k2DW_SZ5SL7JV_OZEZkoq48nl2uphQMhmmK9yw2SiPyplCp7K-sXd2RRu8sgr3BAa6l-8mEfu9xTNUtQGU3tNg9SVInUFSRE'];
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
        $Firbase_API_KEY = 'AAAASG3qqzk:APA91bEXfBwjnfT4wgcEteBvRt5pfS-zxevfLFCbPWBx8HXeoVRlpfVymQeY_9ktxaLCXPtquweBrhaomIaidpE_cbcR7SZwbVdbQN5y5hGE_AAusGSNv5uvddL7zLB1tHbJlz2wtGgO';
        // 'AAAASG3qqzk:APA91bE5-yKsR2GwB-p8ClJRg2oFqE7ERrIWSEOoksfDUuoXtktD4flDlnO-bQUu09k8VErtFxf9veZt70X6PZ6tCSfQ4ev3Ugg9Vz0BoTS34Ggn_HMnztj__0uGcnv_y_1fxuOXcTBR';

        // $Firbase_API_KEY = 'AAAAbOBP3Tg:APA91bG4xtId8xJneVeIq3ThmAKhKkm7U3VyHoTlgK0J_R238FyEKQ1y36LzN0rZsrXrighQX7IvBY3VJ1_yPHPOVpUDPP9JrBLSFZeb3fAu-aEvU5I6M_VjxoT0xq26dNsmaDQAIADe';

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
        $response = curl_exec($ch);
        $response = json_decode($response);
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