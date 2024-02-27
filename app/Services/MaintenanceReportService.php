<?php

namespace App\Services;

use App\Models\BookingService;
use App\Models\MaintenanceReport;

class MaintenanceReportService
{
    public function __construct(private ImageService $imageService, private PdfService $pdfService)
    {
    }

    public function create($request, $garage, $carLicense)
    {
        $data = $request->validated();
        $data['garage_id'] = $garage->id;
        $data['car_license_id'] = $carLicense->id;

        if ($request->hasFile('pdf')) {
            if ($request->hasFile('images')) {
                return response()->json(['message' => 'You can only upload one of the attachments (pdf or images)'], 422);
            }
            $data['pdf'] = $this->pdfService->store($request->file('pdf'), 'maintenance_reports');
        }

        $maintenanceReport = MaintenanceReport::create($data);
        $this->imageService->storeMedia($request, $maintenanceReport->id, 'maintenance_report', 'public/images/maintenance_reports', url("api/images/Maintenance-Report/"));

        return $maintenanceReport;
    }

    public function update($request, $maintenanceReport)
    {
        $data = $request->validated();
        if ($request->hasFile('pdf')) {
            if ($request->hasFile('images')) {
                return response()->json(['message' => 'You can only upload one of the attachments (pdf or images)'], 422);
            }
            $data['pdf'] = $this->pdfService->store($request->file('pdf'), 'maintenance_reports');
        }

        $maintenanceReport->update($data);
        $this->imageService->storeMedia($request, $maintenanceReport->id, 'maintenance_report', 'public/images/maintenance_reports', url("api/images/Maintenance-Report/"));

        return $maintenanceReport;
    }

    public function delete($maintenanceReport)
    {
        $this->pdfService->delete($maintenanceReport->pdf, 'maintenance_reports');
        $this->imageService->deleteMedia($maintenanceReport->id, 'maintenance_reports', url("api/images/Maintenance-Report/"), '');
        $maintenanceReport->delete();
    }
}
