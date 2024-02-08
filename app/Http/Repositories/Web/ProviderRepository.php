<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\ProviderInterface;
use App\Models\Address;
use App\Models\Admin\Service;
use App\Models\GarageData;
use App\Models\Taxe;
use App\Models\User;
use App\Services\ImageService;

/**
 * EProvider => GarageData
 * GarageData Types => 0 -> private, 1 -> company
 * phone_number and name from garage user (not form field)
 */
class ProviderRepository implements ProviderInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $eProviders = GarageData::with([
            'user.garage_information', 'address', 'taxe', 'media'
        ])->paginate(10);
        return view('e_providers.index', ['dataTable' => $eProviders]);
    }

    public function create()
    {
        $eProviderType = [
            '0' => trans('lang.private'),
            '1' => trans('lang.company'),
        ];
        $eProviderUser = User::where('role_id', 4)->whereDoesntHave('garage_data')->pluck('full_name', 'id')->toArray();
        $eProviderAddress = Address::pluck('address', 'id')->toArray();
        $eProviderTax = Taxe::pluck('value', 'id')->toArray();
        return view('e_providers.create', compact('eProviderType', 'eProviderUser', 'eProviderAddress', 'eProviderTax'));
    }

    public function store($request)
    {
        $requestData = $request->validated();
        if (User::find($request->garage_id)->role_id != 4) return;

        $requestData['check_servic_id'] = 0;
        $eProvider = GarageData::create($requestData);
        if ($request->hasFile('image')) {
            $eProvider->media()->create([
                'type' => 'garage_data',
                'image' => $this->imageService->store($request->image, 'providers', 'garage')
            ]);
        }

        $service = Service::create([
            'name' => 'check service',
            'price' => $request->checkServicePrice,
            'price_unit' => 1,
            'featured' => true,
            'enable_booking' => true,
            'available' => true,
            'provider_id' => $eProvider->id
        ]);
        $eProvider->update(['check_servic_id' => $service->id]);

        return redirect()->route('eProviders.index')->with([
            'success' => 'Created successfully'
        ]);
    }

    public function show($id)
    {
        $eProvider = GarageData::findOrFail($id);
        return view('e_providers.show', compact('eProvider'));
    }

    public function edit($id)
    {
        $eProvider = GarageData::findOrFail($id);
        $eProviderType = [
            '0' => trans('lang.private'),
            '1' => trans('lang.company'),
        ];
        $eProviderUser = User::where('role_id', 4)->whereDoesntHave('garage_data')->get();
        $eProviderUser = collect([$eProvider->user])->concat($eProviderUser)->pluck('full_name', 'id')->toArray();
        $eProviderAddress = Address::pluck('address', 'id')->toArray();
        $eProviderTax = Taxe::pluck('value', 'id')->toArray();
        return view('e_providers.edit', compact('eProvider', 'eProviderType', 'eProviderUser', 'eProviderAddress', 'eProviderTax'));
    }

    public function update($request, $id)
    {
        $eProvider = GarageData::findOrFail($id);
        $requestData = $request->validated();

        $eProvider->update($requestData);
        if ($request->hasFile('image')) {
            $eProvider->media()->updateOrCreate([
                'type' => 'garage_data'
            ], [
                'image' => $this->imageService->update($eProvider->media()->first()?->imageName(), $request->image, 'providers', 'garage')
            ]);
        }

        return redirect()->route('eProviders.index')->with([
            'success' => 'Updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $eProvider = GarageData::findOrFail($id);

        $this->imageService->delete($eProvider->media()->first()?->imageName(), 'providers');
        $eProvider->media()->delete();
        $eProvider->delete();

        return redirect()->route('eProviders.index')->with([
            'success' => 'Deleted successfully'
        ]);
    }
}