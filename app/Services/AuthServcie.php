<?php

namespace App\Services;

use App\Models\CompanyInformation;
use App\Models\FirbaseToken;
use App\Models\GarageInformation;
use App\Models\MultiAuthUser;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\WinchInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServcie
{
    // function __construct(private MyfatoorhService $myfatoorhService)
    // {
    // }
    public function credentialUser($request)
    {
        $credentials = request(['email', 'password']);
        if ($token = auth()->attempt($credentials)) {
            $user = auth()->user();
            $user->api_token = $token;
            $this->createOrUpdateFirbaseTokenUser($user->id);
            return $user;
        }
        return null;
    }
    public function respondWithToken($user, $role_type)
    {
        return response()->json([
            'success' => true,
            'data' => $user,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            // 'role_type' => $role_type
            "message" => "User retrieved successfully"

        ]);
    }

    public function createUser($fullName, $email, $password, $role_id)
    {
        return User::create([
            'full_name' => $fullName,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role_id
        ]);
    }

    public function createUserInfo($phone_number, $userId)
    {
        return UserInformation::create([
            'user_id' => $userId,
            'phone_number' => $phone_number,
        ]);
    }
    public function createWinchInfo($phone_number, $winchId)
    {
        return WinchInformation::create([
            'winch_id' => $winchId,
            'phone_number' => $phone_number,
        ]);
    }

    public function createGarageInfo($phone_number, $garage_type, $garageId)
    {
        return GarageInformation::create([
            'garage_id' => $garageId,
            'phone_number' => $phone_number,
            'garage_type' => $garage_type,
        ]);
    }



    // public function editNameImage($data)
    // {
    //     $data['company_logo'] = 'company_logo' . time() . '.' . $data['company_logo']->extension();

    //     if ($data['identity_confirmation'] == 'passport')
    //         $data['passport_image'] = 'passport_image' . time() . '.' . $data['passport_image']->extension();
    //     else {
    //         $data['front_side_id_image'] = 'front_side_id_image' . time() . '.' . $data['front_side_id_image']->extension();
    //         $data['back_side_id_image'] = 'back_side_id_image' . time() . '.' . $data['back_side_id_image']->extension();
    //     }
    //     return $data;
    // }


    public function createOrUpdateFirbaseTokenUser($user_id)
    {
        FirbaseToken::updateOrCreate([
            'fcsToken' => request()->header('fcsToken'),
        ], [
            'user_id' => $user_id
        ]);
    }
}
