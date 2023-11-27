<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\ServiceInterface;
use App\Models\Admin\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ServiceRepository implements ServiceInterface
{
    public function index()
    {
        $servicesWithItems = Service::with('items')->get();
        return response()->json([
            'data' => $servicesWithItems
        ]);
    }

    public function store($request)
    {
        $requestData = request()->all();
        if ($request->has('image')) {
            $requestData['image'] = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs("public/images/admin/services", $requestData['image']);
        }
        $service = Service::create($requestData);
        $service->items()->attach($requestData['items']);
        return response()->json([
            'message' => 'created successfully',
            'data' => $service,
        ]);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id)->load('items');
        return response()->json([
            'data' => $service
        ]);
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
        $service->update($requestData);
        $service->items()->sync($requestData['items']);
        return response()->json([
            'message' => 'updated successfully',
            'data' => $service,
        ]);
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        if ($service->image) {
            $pathOldImage  = storage_path("app/public/images/admin/services/" . $service->image);
            if (File::exists($pathOldImage)) {
                unlink($pathOldImage);
            }
        }
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
