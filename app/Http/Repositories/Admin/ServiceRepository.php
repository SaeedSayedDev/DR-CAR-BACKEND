<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\ServiceInterface;
use App\Models\Admin\Service;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ServiceRepository implements ServiceInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $userAddress = auth()->user()->address;
        dd($userAddress);
        $services = Service::whereHas('provider', function ($q) use ($userAddress) {
            $q->selectRaw('*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(latitude)))) AS distance_in_km', [$userAddress->latitude, $userAddress->longitude, $userAddress->latitude])
                ->having('distance_in_km', '<=', 'availability_range');
        })
            ->with('provider.user.userRole', 'provider.user.media', 'media', 'items', 'favourite')
            ->withSum('review', 'review_value')
            ->withCount('review')
            ->get()
            ->map(function ($service) {
                $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
                $service->is_favorite = $service->favourite->count() > 0 ? true : false;
                unset($service->favourite);
                return  $service;
            });
        return ['data' => $services];
    }
    public function servicesProvider($provider_id)
    {
        $userAddress = auth()->user()->address;
        $services = Service::where()->whereHas('provider', function ($q) use ($userAddress) {
            $q->selectRaw('*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + 
            sin(radians(?)) * sin(radians(latitude)))) AS distance_in_km', [$userAddress->latitude, $userAddress->longitude, $userAddress->latitude])
                ->having('distance_in_km', '<=', 'availability_range');
        })
            ->with('provider.user.userRole', 'provider.user.media', 'media', 'items', 'favourite')
            ->withSum('review', 'review_value')
            ->withCount('review')
            ->get()
            ->map(function ($service) {
                $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
                $service->is_favorite = $service->favourite->count() > 0 ? true : false;
                unset($service->favourite);
                return  $service;
            });
        return [
            'success' => true,
            'data' => $services,
            "message" => "Services retrieved successfully"

        ];
    }
    public function show($id)
    {
        $service = Service::with('provider.userRole', 'provider.media', 'media', 'items', 'favourite')
            ->withSum('review', 'review_value')
            ->withCount('review')
            ->findOrFail($id);

        $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
        $service->is_favorite = $service->favourite->count() > 0 ? true : false;
        unset($service->favourite);


        return [
            'success' => true,
            'data' => $service,
            "message" => "Service retrieved successfully"
        ];
    }

    public function store($request)
    {
        $requestData = request()->all();
        $requestData['provider_id'] = auth()->user()->garage_data->id;

        if (!isset($request->discount_price) or isset($request->discount_price) and $request->discount_price == 0) {
            $requestData['discount_price'] = $request->price;
        }
        DB::beginTransaction();

        $service = Service::create($requestData);

        $this->imageService->storeMedia($request, $service->id, 'service', 'public/images/admin/services', url("api/images/Service/"));
        DB::commit();

        $service->items()->attach($requestData['items']);
        return response()->json(['Success' => true, 'data' => $service, 'message' => 'success']);
    }



    public function update($request, $id)
    {
        $service = Service::findOrFail($id);
        $requestData = request()->all();
        if ($request->has('image')) {
            if ($service->image) {
                $pathOldImage  = storage_path("app/public/images/admin/services/" . $service->image);
                if (File::exists($pathOldImage)) {
                    unlink($pathOldImage);
                }
            }
            $requestData['image'] = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs("public/images/admin/services", $requestData['image']);
        }

        $requestData['image'] = $this->imageService->update($request, $service, 'admin/services');


        $service->update($requestData);
        $requestData = $request->all();
        foreach (['en', 'ar'] as $locale) {
            $service->translateOrNew($locale)->name = $requestData['name'][$locale];
            $service->translateOrNew($locale)->desc = $requestData['desc'][$locale];
        }
        $service->save();

        $service->items()->sync($requestData['items']);
        return response()->json([
            'message' => 'updated successfully',
            'data' => $service,
        ]);
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        // $this->imageService->delete($service, 'admin/services');
        $service->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}