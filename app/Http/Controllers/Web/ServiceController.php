<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ServiceRequest;
use App\Models\Admin\Service;
use App\Models\GarageData;
use App\Models\User;
use App\Services\ImageService;

class ServiceController extends Controller
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $services = Service::with('provider:id,name')->paginate(10);

        return view('e_services.index', ['dataTable' => $services]);
    }

    public function service(Service $service)
    {
        $services = Service::where('id', $service->id)->with('provider:id,name')->paginate(10);

        return view('e_services.index', ['dataTable' => $services]);
    }

    public function create()
    {
        $eProvider = GarageData::pluck('name', 'id')->toArray();

        return view('e_services.create', compact('eProvider'));
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();

        $service = Service::create($data);
        if ($request->hasFile('image')) {
            $service->media()->create([
                'type' => 'service',
                'image' => $this->imageService->store($request->image, 'admin/services', 'Service')
            ]);
        }

        return redirect()->route('eServices.index')->withSuccess(trans('lang.created_success'));
    }

    public function edit(Service $eService)
    {
        $eProvider = GarageData::pluck('name', 'id')->toArray();

        return view('e_services.edit', compact('eService', 'eProvider'));
    }

    public function update(ServiceRequest $request, Service $eService)
    {
        $data = $request->validated();
        
        $eService->update($data);
        if ($request->hasFile('image')) {
            $eService->media()->updateOrCreate([
                'type' => 'service'
            ], [
                'image' => $this->imageService->update($eService->media()->first()?->imageName(), $request->image, 'admin/services', 'Service')
            ]);
        }

        return redirect()->route('eServices.index')->withSuccess(trans('lang.updated_success'));
    }

    // public function destroy(Service $eService)
    // {
    //     if ($eService->slide()->exists()) {
    //         return redirect()->route('eServices.index')->with('error', 'Cannot delete service. It is associated with slides.');
    //     }

    //     $this->imageService->delete($eService->media()->first()?->imageName(), 'admin/services');
    //     $eService->media()->delete();
    //     $eService->delete();
        
    //     return redirect()->route('eServices.index')->withSuccess(trans('lang.deleted_success'));
    // }

    public function user(User $user)
    {
        if (!$user->garage_data) abort(404);

        $services = $user->garage_data->services()->with('provider:id,name')->paginate(10);

        return view('e_services.index', ['dataTable' => $services]);
    }

    public function approve(Service $service)
    {
        $service->update(['status' => 1]);

        return redirect()->route('eServices.index')->withSuccess(trans('lang.approved_success'));
    }

    public function reject(Service $service)
    {
        $service->update(['status' => 2]);

        return redirect()->route('eServices.index')->withSuccess(trans('lang.rejected_success'));
    }
}
