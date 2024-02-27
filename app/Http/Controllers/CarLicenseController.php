<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarLicenseRequest;
use App\Models\CarLicense;
use App\Services\ImageService;

class CarLicenseController extends Controller
{
    private $user;
    function __construct(private ImageService $imageService)
    {
        $this->user = auth()->user();
    }

    public function show()
    {
        $carLicense = $this->user->carLicense;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.'], 404);
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

        if ($this->user->carLicense) {
            return response()->json(['message' => 'User already has a car license.'], 422);
        }
        
        $data['user_id'] = $this->user->id;
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
        $carLicense = $this->user->carLicense;

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

    public function destroy()
    {
        $carLicense = $this->user->carLicense;

        if (!$carLicense) {
            return response()->json(['message' => 'User does not have a car license.'], 404);
        }

        $carLicense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    public function trash()
    {
        $deletedCarLicenses = CarLicense::onlyTrashed()->get();

        return $deletedCarLicenses;
    }
}
