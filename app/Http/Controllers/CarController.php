<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CarLicenseInterface;
use App\Http\Interfaces\CarReportInterface;
use App\Http\Requests\CarLicenseRequest;
use App\Models\Car;
use App\Http\Requests\CarReportRequest;
use App\Models\BookingService;
use App\Models\CarLicense;
use App\Models\CarReport;

class CarController extends Controller
{
    function __construct(
        private CarLicenseInterface $carLicenseInterface,
        private CarReportInterface $carReportInterface,
    ) {
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

    # Car Report

    public function indexReports(BookingService $bookingService)
    {
        return $this->carReportInterface->index($bookingService);
    }

    public function showReports(CarReport $carReport)
    {
        return $this->carReportInterface->show($carReport);
    }

    public function storeReports(BookingService $bookingService, CarReportRequest $request)
    {
        return $this->carReportInterface->store($bookingService, $request);
    }

    public function updateReports(BookingService $bookingService, CarReportRequest $request)
    {
        return $this->carReportInterface->update($bookingService, $request);
    }

    public function deleteReports(BookingService $bookingService)
    {
        return $this->carReportInterface->delete($bookingService);
    }

    public function userReports()
    {
        return $this->carReportInterface->userReports();
    }
}
