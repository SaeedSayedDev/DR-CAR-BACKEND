<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceReportRequest;
use App\Models\BookingService;
use App\Models\MaintenanceReport;
use App\Services\MaintenanceReportService;

class MaintenanceReportController extends Controller
{
    public function __construct(private MaintenanceReportService $maintenanceReportService)
    {
    }

    public function index()
    {
        $maintenanceReports = auth()->user()->maintenanceReports;

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $maintenanceReports,
        ]);
    }

    public function show(MaintenanceReport $maintenanceReport)
    {
        $this->authorize('view', $maintenanceReport);

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $maintenanceReport,
        ]);
    }

    public function store(MaintenanceReportRequest $request, BookingService $bookingService)
    {
        $carLicense = $bookingService->user->carLicense;
        if (!$carLicense) {
            return response()->json(['message' => 'Car license not found'], 404);
        }
        
        $maintenanceReport = $this->maintenanceReportService->create($request, auth()->user(), $carLicense);

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $maintenanceReport,
        ], 201);
    }

    public function update(MaintenanceReportRequest $request, MaintenanceReport $maintenanceReport)
    {
        $this->authorize('update', $maintenanceReport);

        $maintenanceReport = $this->maintenanceReportService->update($request, $maintenanceReport);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $maintenanceReport,
        ]);
    }

    public function destroy(MaintenanceReport $maintenanceReport)
    {
        $this->authorize('delete', $maintenanceReport);

        $this->maintenanceReportService->delete($maintenanceReport);

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
