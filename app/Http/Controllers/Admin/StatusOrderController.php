<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Admin\StatusOrderInterface;
use App\Http\Requests\Admin\StatusOrderRequest;

class StatusOrderController extends Controller
{
    public function __construct(private StatusOrderInterface $statusOrderInterface)
    {
    }

    public function index()
    {
        return $this->statusOrderInterface->index();
    }

    public function store(StatusOrderRequest $request)
    {
        return $this->statusOrderInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->statusOrderInterface->show($id);
    }

    public function update(StatusOrderRequest $request, string $id)
    {
        return $this->statusOrderInterface->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->statusOrderInterface->delete($id);
    }
}
