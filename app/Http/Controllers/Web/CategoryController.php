<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Web\CategoryInterface;
use App\Http\Requests\Web\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct(private CategoryInterface $categoryInterface)
    {
    }

    public function index()
    {
        return $this->categoryInterface->index();
    }

    public function create()
    {
        return $this->categoryInterface->create();
    }
    

    public function store(CategoryRequest $request)
    {
        return $this->categoryInterface->store($request);
    }

    public function show(string $id)
    {
        return $this->categoryInterface->show($id);
    }

    public function edit(string $id)
    {
        return $this->categoryInterface->edit($id);
    }

    public function update(CategoryRequest $request, string $id)
    {
        return $this->categoryInterface->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->categoryInterface->destroy($id);
    }
}
