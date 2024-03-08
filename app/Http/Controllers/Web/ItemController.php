<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\ItemInterface;
use App\Http\Requests\Web\ItemRequest;
use App\Models\Admin\Category;

class ItemController extends Controller
{
    public function __construct(private ItemInterface $itemInterface)
    {
    }

    public function index()
    {
        return $this->itemInterface->index();
    }

    public function create()
    {
        return $this->itemInterface->create();
    }
    
    public function store(ItemRequest $request)
    {
        return $this->itemInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->itemInterface->show($id);
    }

    public function edit(string $id)
    {
        return $this->itemInterface->edit($id);
    }

    public function update(ItemRequest $request, string $id)
    {
        return $this->itemInterface->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->itemInterface->destroy($id);
    }

    public function category(Category $category)
    {
        return $this->itemInterface->category($category);
    }
}
