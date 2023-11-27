<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Models\CompanyInformation;
use App\Models\FirbaseToken;
use App\Models\User;
use App\Models\UserInformation;
use App\Services\AuthServcie;
use Illuminate\Support\Facades\DB;
use App\Services\OtpService;
use Illuminate\Support\Facades\File;
use PDO;

class AuthRepository implements AuthInterface
{

    function __construct(private AuthServcie $authServcie, private OtpService $otpService)
    {
    }
    public function login($request)
    {
        $credentials = request(['email', 'password']);
        if ($token = auth()->claims(['role_type' => 'user'])->attempt($credentials)) {
            // $user_id = auth()->user()->id;
            // $this->authServcie->createOrUpdateFirbaseTokenUser(false, $user_id);
            return $this->authServcie->respondWithToken($token);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function register($request)
    {
        DB::beginTransaction();
        if ($request->role_id != 1)
            $user = $this->authServcie->createUser($request->full_name, $request->email,  $request->password, $request->role_id);
        else
            return response()->json(['message' => 'this role not avalible'], 404);

        if ($request->phone_number) {
            if ($request->role_id == 2)
                $this->authServcie->createUserInfo($request->phone_number,  $user->id);
            else if ($request->role_id == 3)
                $this->authServcie->createWinchInfo($request->phone_number,  $user->id);
            else if ($request->role_id == 4)
                $this->authServcie->createGarageInfo($request->phone_number, $request->garage_type,  $user->id);
        }
        $this->otpService->createEmail($user->email, $user->id, 'user');
        DB::commit();
        return response()->json(['message' => 'please verify your email']);
    }


    public function me()
    {

        if ($admin = auth()->guard('admin')->user()) {
            return response()->json($admin);
        }
        $user = auth()->user();
        $imageUrlUser = url("api/images/user");
        if ($user->user_type == 'user') {
            $imageUrlCompany = url("api/images/company");
            $imageUrlEmployee = url("api/images/employee");

            $user->user_information;
            $user->bookingMe;
            $user->favouriteCompany;
            $user->favouriteEmployee;

            return response()->json([
                'data' => $user, 'imageUrlUser' => $imageUrlUser,
                'imageUrlCompany' => $imageUrlCompany, 'imageUrlEmployee' => $imageUrlEmployee
            ]);
        } elseif ($user->user_type == 'company') {
            $logoUrlCompany = url("api/images/company");
            $user->company_information;
            $user->reviewCompany;
            if ($user->company_information->company_type == 'cleaning') {
                $user->services;
            }
            return response()->json(['data' => $user, 'imageUrlUser' => $imageUrlUser, 'logoUrlCompany' => $logoUrlCompany]);
        }
    }
}
