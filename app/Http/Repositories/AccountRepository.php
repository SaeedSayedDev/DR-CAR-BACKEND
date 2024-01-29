<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AccountInterface;
use App\Models\Admin\Service;
use App\Models\availabilityTime;
use App\Models\GarageData;
use App\Models\User;
use App\Models\WinchInformation;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;

class AccountRepository implements AccountInterface
{
    function __construct(private ImageService $imageService)
    {
    }
    public function show()
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        $user->load(match ($user->role_id) {
            2 => 'user_information',
            3 => 'winch_information',
            4 => 'garage_information',
        });
        return response()->json([
            'data' => $user
        ]);
    }
    public function update($request)
    {
        $requestData = request()->all();
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        $user->update($requestData);

        $this->imageService->storeMedia($request, $user->id, 'user', 'public/images/accounts', url("api/images/Provider/"));

        switch ($user->role_id) {
            case 2:
                // $requestData['image'] = $this->imageService->update($request, $user->user_information, 'accounts');
                $user->user_information->update($requestData);
                break;
            case 3:
                // $requestData['image'] = $this->imageService->update($request, $user->winch_information, 'accounts');
                $user->winch_information->update($requestData);
                break;
            case 4:
                // $requestData['image'] = $this->imageService->update($request, $user->garage_information, 'accounts');
                $user->garage_information->update($requestData);
                break;
        }
        return response()->json([
            'data' => $user
        ]);
    }

    public function delete()
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);
        $user->delete();

        switch ($user->role_id) {
            case 2:
                // $this->imageService->delete($user->user_information, 'accounts');
                $user->user_information->delete();
                break;
            case 3:
                // $this->imageService->delete($user->winch_information, 'accounts');
                $user->winch_information->delete();
                break;
            case 4:
                // $this->imageService->delete($user->garage_information, 'accounts');
                $user->garage_information->delete();
                break;
        }
        $user->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }


    public function storeGarageData($request)
    {
        $data = $request->all();
        DB::beginTransaction();

        $GarageData = GarageData::updateOrCreate(
            [
                'garage_id' => auth()->user()->id,
            ],
            $data
        );

        Service::create([
            'name' => 'check service',
            'price' => $request->checkServicePrice,
            'price_unit' => 1,
            'featured' => true,
            'enable_booking' => true,
            'available' => true,
            'provider_id' => $GarageData->id

        ]);
        DB::commit();

        return response()->json(['message' => 'success', 'data' => $GarageData]);
    }

    public function availabilityTime($request)
    {
        availabilityTime::updateOrCreate(
            [
                'provider_id' => $request->provider_id
            ],
            $request->all()
        );
        return response()->json(['message' => 'success']);
    }

    public function updateWinchAvailableNow()
    {
        $user = auth()->user();
        if (isset($user->winch_information)) {
            $winchInformation = WinchInformation::where('winch_id', $user->id)->first();
            if ($winchInformation->available_now == 0)
                $winchInformation->update(['available_now' => 1]);
            elseif ($winchInformation->available_now == 1)
                $winchInformation->update(['available_now' => 0]);
            return response()->json(["success" => true, 'data' => $user->winch_information, "message" => "Address Updated successfully"]);
        }
    }
}
