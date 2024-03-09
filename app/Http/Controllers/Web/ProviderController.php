<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\ProviderInterface;
use App\Http\Requests\Web\ProviderRequest;
use App\Models\GarageData;

class ProviderController extends Controller
{
    public function __construct(private ProviderInterface $providerInterface)
    {
    }

    public function index()
    {
        return $this->providerInterface->index();
    }

    public function provider(GarageData $provider)
    {
        return $this->providerInterface->provider($provider);
    }

    public function create()
    {
        return $this->providerInterface->create();
    }
    
    public function store(ProviderRequest $request)
    {
        return $this->providerInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->providerInterface->show($id);
    }

    public function edit(string $id)
    {
        return $this->providerInterface->edit($id);
    }

    public function update(ProviderRequest $request, string $id)
    {
        return $this->providerInterface->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->providerInterface->destroy($id);
    }
}
