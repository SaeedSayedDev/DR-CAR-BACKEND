<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Admin\ServiceInterface;
use App\Http\Requests\Admin\ServiceRequest;

class ServiceController extends Controller
{
    public function __construct(private ServiceInterface $serviceInterface)
    {
    }

    public function index()
    {
        return $this->serviceInterface->index();
    }

    public function store(ServiceRequest $request)
    {
        return $this->serviceInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->serviceInterface->show($id);
    }

    public function update(ServiceRequest $request, string $id)
    {
        return $this->serviceInterface->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->serviceInterface->delete($id);
    }
}
