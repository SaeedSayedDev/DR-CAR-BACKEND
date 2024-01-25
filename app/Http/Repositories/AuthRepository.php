<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Models\CompanyInformation;
use App\Models\FirbaseToken;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
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
        if ($user = $this->authServcie->credentialUser($request)) {
            return $this->authServcie->respondWithToken($user, $user->userRole->name);
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
                $this->authServcie->createGarageInfo($request->phone_number,  $user->id);
        }

        // $this->otpService->createEmail($user->email, $user->id, 'user');
        DB::commit();
        $user = $this->authServcie->credentialUser($request);
        $user->user_role;

        Wallet::create([
            'name' => $user->full_name . ' Wallet',
            'user_id' => $user->id,
            'total_balance' => 0,
            'awating_transfer' => 0,
        ]);
        return response()->json([
            "success" => true,
            'data' => $user
        ]);
    }


    public function me()
    {
        $user = auth()->user();
        $user->load(match ($user->role_id) {
            2 => 'user_information',
            3 => 'winch_information',
            4 => 'garage_information',
        });

        $user->media;


        return response()->json([
            'data' => $user,
        ]);
    }
    ################# Dashboard #################

    public function webLogin($request)
    {
        $credentials = request(['email', 'password']);
        if (auth('web')->attempt($credentials)) {
            if (auth('web')->user()->role_id == 1) { // Admin
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                auth('web')->logout();
                return redirect()->back()->withErrors('Unauthorized');
            }
        }
        return redirect()->back()->withErrors('Invalid credentials');
    }

    public function webLogout()
    {
        auth('web')->logout();
        return redirect()->route('login.page');
    }
}
