<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CarLicenseInterface;
use App\Models\CarLicense;
use App\Services\ImageService;

class CarLicenseRepository implements CarLicenseInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function show()
    {
        $carLicense = auth()->user()->carLicense;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $carLicense->load('media'),
        ]);
    }

    public function store($request)
    {
        $data = $request->validated();

        if (auth()->user()->carLicense) {
            return response()->json(['message' => 'User already has a car license.'], 422);
        }
        
        $data['user_id'] = auth()->id();
        $carLicense = CarLicense::create($data);
        $this->imageService->storeMedia($request, $carLicense->id, 'car_license', 'public/images/admin/cars/licenses', url("api/images/CarLicense/"));

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $carLicense->load('media'),
        ], 201);
    }

    public function update($request)
    {
        $data = $request->validated();
        $carLicense = auth()->user()->carLicense;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.'], 404);
        }

        $carLicense->update($data);
        $this->imageService->storeMedia($request, $carLicense->id, 'car_license', 'public/images/admin/cars/licenses', url("api/images/CarLicense/"));

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $carLicense->load('media'),
        ]);
    }

    public function delete()
    {
        $carLicense = auth()->user()->carLicense;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.'], 404);
        }

        // soft delete + keep media
        $carLicense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
