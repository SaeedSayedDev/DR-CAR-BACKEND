<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ServiceReportInterface;
use App\Models\ServiceReport;
use App\Services\ImageService;
use App\Services\PdfService;

class ServiceReportRepository implements ServiceReportInterface
{
    public function __construct(private ImageService $imageService, private PdfService $pdfService)
    {
    }

    public function store($bookingService, $request)
    {
        $garage = auth()->user();
        $carLicense = $bookingService->user->carLicense;

        if ($garage->id != $bookingService->service->provider->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } elseif ($bookingService->order_status_id < 4) {
            return response()->json(['message' => 'You can not report before your status is ready'], 404);
        } elseif (!$carLicense) {
            return response()->json(['message' => 'Car license not found'], 404);
        } elseif (ServiceReport::where('car_license_id', $carLicense->id)->where('booking_service_id', $bookingService->id)->exists()) {
            return response()->json(['message' => 'Report already exists'], 404);
        }

        $data = $request->validated();
        $data['garage_id'] = $garage->id;
        $data['car_license_id'] = $carLicense->id;
        $data['booking_service_id'] = $bookingService->id;

        if ($request->hasFile('pdf') && $request->hasFile('images')) {
            return response()->json(['message' => 'You can only upload one of the attachments (pdf or images)'], 422);
        } elseif ($request->hasFile('pdf')) {
            $data['pdf'] = $this->pdfService->store($request->file('pdf'), 'service_reports');
        }

        $report = ServiceReport::create($data);
        $this->imageService->storeMedia($request, $report->id, 'service_report', 'public/images/service_reports', url("api/images/Report/"));

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $report->load('media'),
        ]);
    }

    public function update($bookingService, $request)
    {
        /** @var User $garage */
        $garage = auth()->user();
        $report = $garage->garageReports()->where('booking_service_id', $bookingService->id)->first();

        if ($garage->id != $bookingService->service->provider->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } elseif (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('pdf') && $request->hasFile('images')) {
            return response()->json(['message' => 'You can only upload one of the attachments (pdf or images)'], 422);
        } elseif ($request->hasFile('pdf')) {
            $this->imageService->deleteMedia($report->id, 'service_report', 'public/images/service_reports', '');
            $data['pdf'] = $this->pdfService->update($report->pdf, $request->file('pdf'), 'service_reports');
        } elseif ($request->hasFile('images')) {
            $this->pdfService->delete($report->pdf, 'service_reports');
            $this->imageService->storeMedia($request, $report->id, 'service_report', 'public/images/service_reports', url("api/images/Report/"));
            $data['pdf'] = null;
        }

        $report->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'data' => $report->load('media'),
        ]);
    }

    public function delete($bookingService)
    {
        /** @var User $garage */
        $garage = auth()->user();
        $report = $garage->garageReports()->where('booking_service_id', $bookingService->id)->first();

        if ($garage->id != $bookingService->service->provider->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $this->pdfService->delete($report->pdf, 'service_reports');
        $this->imageService->deleteMedia($report->id, 'service_reports', url("api/images/Report/"), '');
        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }

    public function historyGarage($carLicense)
    {
        $reports = $carLicense->reports()->with('media')->get();

        if (!$reports->count()) {
            return response()->json(['message' => 'No reports found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $reports,
        ]);
    }

    public function historyUser()
    {
        $carLicense = auth()->user()->carLicense;

        $reports = $carLicense->reports()->with('media')->get();

        if (!$reports->count()) {
            return response()->json(['message' => 'No reports found'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $reports,
        ]);
    }
}
