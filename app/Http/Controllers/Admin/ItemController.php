<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Admin\ItemInterface;
use App\Http\Requests\Admin\ItemRequest;

class ItemController extends Controller
{
    public function __construct(private ItemInterface $itemInterface)
    {
    }

    public function index()
    {
        return $this->itemInterface->index();
    }

    public function store(ItemRequest $request)
    {
        return $this->itemInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->itemInterface->show($id);
    }

    public function update(ItemRequest $request, string $id)
    {
        return $this->itemInterface->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->itemInterface->delete($id);
    }
}
