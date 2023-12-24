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
        $services = Service::with('provider.userRole', 'provider.media', 'media', 'items')->get();

        $service_image_url = url("api/images/Service/");
        $provider_image_url = url("api/images/Provider/");

        return response()->json([
            'data' => $services,
            'service_image_url' => $service_image_url,
            'provider_image_url' => $provider_image_url

        ]);
    }
    
    public function show($id)
    {
        $service = Service::findOrFail($id)->load('provider.userRole', 'provider.media', 'media', 'items');
        $imageUrl = url("api/images/Service/");

        return response()->json([
            'data' => $service,
            'image_url' => $imageUrl
        ]);
    }

    public function store($request)
    {
        $requestData = request()->all();
        $requestData['provider_id'] = auth()->user()->id;

        if (!isset($request->discount_price) or isset($request->discount_price) and $request->discount_price == 0) {
            $requestData['discount_price'] = $request->price;
        }
        DB::beginTransaction();

        $service = Service::create($requestData);

        $this->imageService->storeMedia($request, $service->id, 'service', 'public/images/admin/services');
        DB::commit();

        $service->items()->attach($requestData['items']);
        return response()->json(['message' => 'success']);
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
