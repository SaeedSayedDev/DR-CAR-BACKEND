<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CarLicenseInterface;
use App\Http\Requests\CarLicenseRequest;
use App\Models\Car;
use App\Models\CarLicense;

class CarController extends Controller
{
    function __construct(private CarLicenseInterface $carLicenseInterface)
    {
    }
    public function index()
    {
        $cars = Car::get();

        return response()->json(['data' => $cars]);
    }
    public function showCarLicense()
    {
        return $this->carLicenseInterface->show();
    }

    public function storeCarLicense(CarLicenseRequest $request)
    {
        return $this->carLicenseInterface->store($request);
    }

    public function updateCarLicense(CarLicenseRequest $request)
    {
        return $this->carLicenseInterface->update($request);
    }

    public function deleteCarLicense()
    {
        return $this->carLicenseInterface->delete();
    }

    public function trashCarLicense()
    {
        $deletedCarLicenses = CarLicense::onlyTrashed()->get();

        return $deletedCarLicenses;
    }
}
