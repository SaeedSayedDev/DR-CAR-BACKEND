<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Admin\CategoryInterface;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct(private CategoryInterface $categoryInterface)
    {
    }

    public function index()
    {
        return $this->categoryInterface->index();
    }

    public function store(CategoryRequest $request)
    {
        return $this->categoryInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->categoryInterface->show($id);
    }

    public function update(CategoryRequest $request, string $id)
    {
        return $this->categoryInterface->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->categoryInterface->delete($id);
    }
}
