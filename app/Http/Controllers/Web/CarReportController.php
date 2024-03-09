<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\CarLicense;
use App\Models\CarReport;
use App\Models\User;
use Illuminate\Http\Request;

class CarReportController extends Controller
{
    public function index()
    {
        $carReports = CarReport::with('carLicense.user:id,full_name', 'garage:id,full_name')->paginate(10);

        return view('car_reports.index', ['dataTable' => $carReports]);
    }

    public function report(CarLicense $carLicense)
    {
        $carReports = $carLicense->reports()->with('carLicense.user:id,full_name', 'garage:id,full_name')->paginate(10);

        return view('car_reports.index', ['dataTable' => $carReports]);
    }

    public function user(User $user)
    {
        $carReports = $user->carReports()->with('garage:id,full_name')->paginate(10);

        return view('car_reports.index', ['dataTable' => $carReports]);
    }
}
