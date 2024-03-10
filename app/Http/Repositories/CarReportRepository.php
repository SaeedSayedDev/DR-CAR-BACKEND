<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CarReportInterface;
use App\Models\CarReport;
use App\Models\Media;
use App\Services\ImageService;
use App\Services\PdfService;

class CarReportRepository implements CarReportInterface
{
    public function __construct(private ImageService $imageService, private PdfService $pdfService)
    {
    }

    public function index($bookingService)
    {
        $reports = $bookingService->user->carLicense->reports()->with('media')->get();

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $reports,
        ]);
    }

    public function show($carReport)
    {
        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $carReport->load('media'),
        ]);
    }

    public function store($bookingService, $request)
    {
        /** @var User */
        $garage = auth()->user();
        $carLicense = $bookingService->user->carLicense;

        if ($garage->id != $bookingService->service->provider->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } elseif ($bookingService->order_status_id < 4) {
            return response()->json(['message' => 'You can not report before your status is ready'], 404);
        } elseif (!$carLicense) {
            return response()->json(['message' => 'Car license not found'], 404);
        } elseif ($garage->carReports()->where('car_license_id', $carLicense->id)->where('booking_service_id', $bookingService->id)->exists()) {
            return response()->json(['message' => 'Report already exists'], 404);
        }

        $data = $request->validated();
        $data['garage_id'] = $garage->id;
        $data['car_license_id'] = $carLicense->id;
        $data['booking_service_id'] = $bookingService->id;

        if ($request->hasFile('pdf') && $request->hasFile('images')) {
            return response()->json(['message' => 'You can only upload one of the attachments (pdf or images)'], 422);
        }

        $report = CarReport::create($data);

        if ($request->hasFile('pdf')) {
            $this->pdfService->storeMedia($request, $report->id, 'car_report', 'public/images/car_reports', url("api/images/Report/"));
        } else {
            $this->imageService->storeMedia($request, $report->id, 'car_report', 'public/images/car_reports', url("api/images/Report/"));
        }

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
        $report = $garage->carReports()->where('booking_service_id', $bookingService->id)->first();

        if ($garage->id != $bookingService->service->provider->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } elseif (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('pdf') && $request->hasFile('images')) {
            return response()->json(['message' => 'You can only upload one of the attachments (pdf or images)'], 422);
        } elseif ($request->hasFile('pdf')) {
            $this->imageService->deleteMedia($report->id, 'car_report', 'public/images/car_reports', '');
            $this->pdfService->storeMedia($request, $report->id, 'car_report', 'public/images/car_reports', url("api/images/Report/"));
        } elseif ($request->hasFile('images')) {
            $this->pdfService->deleteMedia($report->id, 'car_report', 'public/images/car_reports', '');
            $this->imageService->storeMedia($request, $report->id, 'car_report', 'public/images/car_reports', url("api/images/Report/"));
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
        $report = $garage->carReports()->where('booking_service_id', $bookingService->id)->first();

        if ($garage->id != $bookingService->service->provider->garage_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        $this->imageService->deleteMedia($report->id, 'car_report', 'public/images/car_reports', '');
        $this->pdfService->deleteMedia($report->id, 'car_report', 'public/images/car_reports', '');
        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully',
        ]);
    }


    public function userReports()
    {
        $carLicense = auth()->user()->carLicense;

        $reports = isset($carLicense) ? $carLicense->reports()->with('media')->get() : [];

        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'data' => $reports,
        ]);
    }
}
