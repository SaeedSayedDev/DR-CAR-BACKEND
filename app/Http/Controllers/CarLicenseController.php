<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarLicenseRequest;
use App\Models\CarLicense;
use App\Services\ImageService;

class CarLicenseController extends Controller
{
    function __construct(private ImageService $imageService)
    {
    }

    public function show()
    {
        $carLicense = auth()->user()->carLicense;
        $carLicense->media;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $carLicense,
        ]);
    }

    public function store(CarLicenseRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        if ($user->carLicense) {
            return response()->json(['message' => 'User already has a car license.'], 422);
        }
        
        $data['user_id'] = $user->id;
        $carLicense = CarLicense::create($data);
        $this->imageService->storeMedia($request, $carLicense->id, 'car_license', 'public/images/admin/cars/licenses', url("api/images/CarLicense/"));

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $carLicense,
        ], 201);
    }

    public function update(CarLicenseRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $carLicense = $user->carLicense;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.'], 404);
        }

        $carLicense->update($data);
        $this->imageService->storeMedia($request, $carLicense->id, 'car_license', 'public/images/admin/cars/licenses', url("api/images/CarLicense/"));

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $carLicense,
        ]);
    }
}
