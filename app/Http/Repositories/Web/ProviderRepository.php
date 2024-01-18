<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\ProviderInterface;
use App\Models\User;
use App\Services\ImageService;

class ProviderRepository implements ProviderInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $providers = User::whereIn('role_id', [3, 4])->paginate(10);
        return view('e_providers.index', ['dataTable' => $providers]);
    }

    public function create()
    {
        $eProviderType = [
            '3' => 'Winch',
            '4' => 'Garage',
        ];
        return view('e_providers.create', compact('eProviderType'));
    }

    public function store($request)
    {
        $requestData = $request->validated();
        $requestData['desc'] = strip_tags($request->input('desc'));
        $requestData['image'] = $this->imageService->store($request, 'admin/providers');
        dd($requestData);
        

        return redirect()->route('e_providers.index')->with([
            'success' => 'Created successfully'
        ]);
    }

    public function show($id)
    {
        $provider = User::findOrFail($id);
        return view('e_providers.show', compact('provider'));
    }

    public function edit($id)
    {
        $provider = User::findOrFail($id);
        
        return view('e_providers.edit', compact('provider', 'form'));
    }

    public function update($request, $id)
    {
        $provider = User::findOrFail($id);
        $requestData = $request->validated();
        $requestData['desc'] = strip_tags($request->input('desc'));
        $requestData['image'] = $this->imageService->update($request, $provider, 'admin/providers') ?? $provider->image;

        $provider->update($requestData);

        return redirect()->route('e_providers.index')->with([
            'success' => 'Updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $provider = User::findOrFail($id);
        $this->imageService->delete($provider, 'admin/providers');
        $provider->delete();
        return redirect()->route('e_providers.index')->with([
            'success' => 'Deleted successfully'
        ]);
    }
}
