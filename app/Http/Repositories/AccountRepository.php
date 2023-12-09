<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AccountInterface;
use App\Models\User;
use App\Services\ImageService;

class AccountRepository implements AccountInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->load(match ($user->role_id) {
            2 => 'user_information',
            3 => 'winch_information',
            4 => 'garage_information',
        });
        return response()->json([
            'data' => $user
        ]);
    }

    public function update($request, $id)
    {
        $requestData = request()->all();
        $user = User::findOrFail($id);
        $user->update($requestData);
        switch ($user->role_id) {
            case 2:
                $requestData['image'] = $this->imageService->update($request, $user->user_information, 'accounts');
                $user->user_information->update($requestData);
                break;
            case 3:
                $requestData['image'] = $this->imageService->update($request, $user->winch_information, 'accounts');
                $user->winch_information->update($requestData);
                break;
            case 4:
                $requestData['image'] = $this->imageService->update($request, $user->garage_information, 'accounts');
                $user->garage_information->update($requestData);
                break;
        }
        return response()->json([
            'data' => $user
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        switch ($user->role_id) {
            case 2:
                $this->imageService->delete($user->user_information, 'accounts');
                $user->user_information->delete();
                break;
            case 3:
                $this->imageService->delete($user->winch_information, 'accounts');
                $user->winch_information->delete();
                break;
            case 4:
                $this->imageService->delete($user->garage_information, 'accounts');
                $user->garage_information->delete();
                break;
        }
        $user->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
