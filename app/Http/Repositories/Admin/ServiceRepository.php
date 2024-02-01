<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\ServiceInterface;
use App\Models\Address;
use App\Models\Admin\Service;
use App\Models\GarageData;
use App\Services\AddressService;
use App\Services\ImageService;
use App\Services\ProviderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ServiceRepository implements ServiceInterface
{
    function __construct(private ImageService $imageService, private ProviderService $providerService, private AddressService $addressService)
    {
    }
    public function index($filter_key)
    {
        $services = Service::whereHas('avilabilty_range')->getRelashinIndex()->get()
            ->map(function ($service) use ($filter_key) {
                // if (isset(auth()->user()->address[0])) {
                //     $distance = $this->addressService->calDistance($service->provider->address->latitude, $service->provider->address->longitude, auth()->user()->address[0]->latitude, auth()->user()->address[0]->longitude);

                //     if ($distance > $service->provider->availability_range) {
                //         unset($service);
                //         return;
                //     }
                //     $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
                //     $service->is_favorite = $service->favourite->count() > 0 ? true : false;
                //     unset($service->favourite);
                // if ($filter_key == 4 and $service->featured == false)
                //     unset($service);
                // else
                //     return  $service;
                // }
                // return ;

                // dd($service->featured);


                $service->rate = $service->review_count > 0 ? $service->review_sum_review_value / $service->review_count : 0;
                $service->is_favorite = $service->favourite->count() > 0 ? true : false;
                unset($service->favourite);

                // if ($filter_key == 4 and $service->featured == false)
                //     unset($service);
                // else
                return  $service;
            });

        if ($filter_key == 3)
            $services =  $services->sortByDesc('rate')->values();
        else if ($filter_key == 4)
            $services =  $services->where('featured', true)->values();
        else if ($filter_key == 5)
            $services = $services->sortByDesc('popular_count')->values();


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
        $service = Service::where('provider_id', auth()->user()->garage_data->id)->findOrFail($id);
        if (auth()->user()->garage_data->check_servic_id == $service->id)
            return response()->json(['message' => 'you can not delete this service'], 404);
        $service->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }

    public function recommended()
    {
        $services = Service::with('media', 'review')
            ->withSum('review', 'review_value')
            ->withCount('review', 'popular')
            ->get()->sortByDesc('popular_count')->values()->take(6);
        return [
            'success' => true,
            'data' => $services,
            "message" => "Services retrieved successfully"
        ];
    }
}
