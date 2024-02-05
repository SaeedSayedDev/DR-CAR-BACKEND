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
            "success" => true,
            'message' => 'deleted successfully'
        ]);
    }


    public function storeGarageData($request)
    {
        $data = $request->all();
        $data['check_servic_id'] = 0;
        DB::beginTransaction();

        $GarageData = GarageData::updateOrCreate(
            [
                'garage_id' => auth()->user()->id,
            ],
            $data
        );

        if ($GarageData->check_servic_id == 0) {
            $service = Service::create([
                'name' => 'check service',
                'price' => $request->checkServicePrice,
                'price_unit' => 1,
                'featured' => true,
                'enable_booking' => true,
                'available' => true,
                'provider_id' => $GarageData->id

            ]);
            $GarageData->update(['check_servic_id' => $service->id]);
        }
        DB::commit();

        return response()->json(['success' => true, 'data' => $GarageData]);
    }

    public function availabilityTime($request)
    {
        if (auth()->user()->garage_data) {
            availabilityTime::updateOrCreate(
                [
                    'provider_id' => auth()->user()->garage_data->id,
                    'day' => $request->day
                ],
                $request->all()
            );
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'please create garage data first'], 404);
        }
    }

    public function updateWinchAvailableNow()
    {
        $user = auth()->user();
        if (isset($user->winch_information) and isset($user->addressUser)) {
            // $winchInformation = WinchInformation::where('winch_id', $user->id)->first();
            if ($user->winch_information->available_now == 0)
                $user->winch_information->update(['available_now' => 1]);
            elseif ($user->winch_information->available_now == 1)
                $user->winch_information->update(['available_now' => 0]);
            return response()->json(["success" => true, "message" => "available Updated successfully"]);
        }
        return response()->json(["success" => false, "message" => "Please Create Your Address"], 404);
    }
}
