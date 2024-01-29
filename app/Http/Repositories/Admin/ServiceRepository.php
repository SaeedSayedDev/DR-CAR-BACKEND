<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\ServiceInterface;
use App\Models\Address;
use App\Models\Admin\Service;
use App\Services\ImageService;
use App\Services\ProviderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ServiceRepository implements ServiceInterface
{
    function __construct(private ImageService $imageService, private ProviderService $providerService)
    {
    }
    public function index()
    {


        // $this->calDistance()

        // $earthRadius = 6371; // Radius of the Earth in kilometers

        // // Convert latitude and longitude from degrees to radians
        // $lat1 = deg2rad($lat1);
        // $lon1 = deg2rad($lon1);
        // $lat2 = deg2rad($lat2);
        // $lon2 = deg2rad($lon2);

        // // Haversine formula
        // $dlat = $lat2 - $lat1;
        // $dlon = $lon2 - $lon1;
        // $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // // Calculate distance
        // $distance = $earthRadius * $c;

        // return $distance;

        $services = Service::getRelashinIndex()->get()
            ->map(function ($service) {
                // $distance = $this->calDistance($service->provider->address->latitude, $service->provider->address->longitude, auth()->user()->address[0]->latitude, auth()->user()->address[0]->longitude);
                // // dd($distance);

                // if ($distance > $service->provider->availability_range)
                // {
                //     unset($service);
                //     return ;
                // }
                $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
                $service->is_favorite = $service->favourite->count() > 0 ? true : false;
                unset($service->favourite);

                return  $service;
            });


        return ['data' => $services];
    }

    public function calDistance($lat1, $lon1, $lat2, $lon2)
    {

        // dump($lat1);
        // dump($lon1);
        // dump($lat2);
        // dd($lon2);
        $earthRadius = 6371; // Radius of the Earth in kilometers

        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        // Haversine formula
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calculate distance
        $distance = $earthRadius * $c;

        return $distance;
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
                ->with('provider.user')
                ->with('media', 'items', 'review')
                ->withSum('review', 'review_value')
                ->withCount('review', 'popular')
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
        $service = Service::with('provider.user.userRole', 'provider.user.media', 'media', 'items', 'favourite', 'options.media', 'review')
            ->withSum('review', 'review_value')
            ->withCount('review')
            ->findOrFail($id);


        $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
        $service->is_favorite = $service->favourite->count() > 0 ? true : false;
        unset($service->favourite);

        // return isset($service->provider);
        // return $service;
        $service->provider = $this->providerService->reviewAndRate($service->provider);

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
