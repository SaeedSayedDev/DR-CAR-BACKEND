<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\CategoryInterface;
use App\Models\Admin\Category;
use App\Services\ImageService;

class CategoryRepository implements CategoryInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', ['dataTable' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store($request)
    {
        $requestData = $request->validated();
        $requestData['desc'] = strip_tags($request->input('desc'));
        $requestData['image'] = $this->imageService->store($request, 'admin/categories');

        Category::create($requestData);

        return redirect()->route('categories.index')->with([
            'success' => 'Created successfully'
        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update($request, $id)
    {
        $category = Category::findOrFail($id);
        $requestData = $request->validated();
        $requestData['desc'] = strip_tags($request->input('desc'));
        $requestData['image'] = $this->imageService->update($request, $category, 'admin/categories') ?? $category->image;

        $category->update($requestData);

        return redirect()->route('categories.index')->with([
            'success' => 'Updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->imageService->delete($category, 'admin/categories');
        $category->delete();
        return redirect()->route('categories.index')->with([
            'success' => 'Deleted successfully'
        ]);
    }
}
