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
    {;
        // if ($userAddress = auth()->user()->address) {
        // function ($q) use ($userAddress) {
        //     $q->selectRaw('*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + 
        // sin(radians(?)) * sin(radians(latitude)))) AS distance_in_km', [$userAddress->latitude, $userAddress->longitude, $userAddress->latitude])
        //         ->having('distance_in_km', '<=', 'availability_range');
        // })
        $services = Service::whereHas('provider')
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
        // $service
        // dd($services->review_count);
        return ['data' => $services];
        // }
        // return ['message' => 'Please Enter your Address'];
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
    public function indexGarage()
    {
        if (isset(auth()->user()->garage_data)) {
            $services = Service::where('provider_id', auth()->user()->garage_data->id)
                ->with('media', 'items', 'review')
                ->withSum('review', 'review_value')
                ->withCount('review')
                ->get()
                ->map(function ($service) {
                    $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
                    return  $service;
                });
            return [
                'success' => true,
                'data' => $services,
                "message" => "Services retrieved successfully"
            ];
        }
        return [
            'success' => false,
            "message" => "Please Create Garage"
        ];
    }
    public function show($id)
    {
        $service = Service::with('provider.user.userRole', 'provider.user.media', 'media', 'items', 'favourite', 'options.media')
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
        if (isset(auth()->user()->garage_data)) {
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
        return response()->json(['Success' => false, 'message' => 'Please Create Garage']);
    }



    public function update($request, $id)
    {
        $service = Service::findOrFail($id);
        $requestData = request()->all();

        $service->update($requestData);

        $this->imageService->storeMedia($request, $service->id, 'service', 'public/images/admin/services', url("api/images/Service/"));

        $service->items()->sync($requestData['items']);

        return response()->json(['message' => 'success']);
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