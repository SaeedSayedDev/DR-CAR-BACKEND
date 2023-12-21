<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\CategoryInterface;
use App\Models\Admin\Category;
use App\Services\ImageService;

class CategoryRepository implements CategoryInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $categories = Category::with('items')->get();
        $imageUrl = url("api/images/Category/");
        return response()->json([
            'data' => $categories,
            'image_url' => $imageUrl
        ]);
    }

    public function store($request)
    {
        $requestData = $request->all();
        $requestData['image'] = $this->imageService->store($request, 'admin/categories');

        $category = Category::create([
            'image' => $requestData['image'],
        ]);
        foreach (['en', 'ar'] as $locale) {
            $category->translations()->create([
                'locale' => $locale,
                'name' => $requestData['name'][$locale],
                'desc' => $requestData['desc'][$locale],
            ]);
        }
        $imageUrl = url("api/images/Category/");

        return response()->json([
            'message' => 'stored successfully',
            'data' => $category,
            'image_url' => $imageUrl

        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id)->load('items');
        return response()->json([
            'data' => $category
        ]);
    }

    public function update($request, $id)
    {
        $category = Category::findOrFail($id);
        $requestData = $request->all();
        $requestData['image'] = $this->imageService->update($request, $category, 'admin/categories');

        $category->update([
            'image' => $requestData['image'],
        ]);
        foreach (['en', 'ar'] as $locale) {
            $category->translateOrNew($locale)->name = $requestData['name'][$locale];
            $category->translateOrNew($locale)->desc = $requestData['desc'][$locale];
        }
        $category->save();

        return response()->json([
            'message' => 'updated successfully',
            'data' => $category,
        ]);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $this->imageService->delete($category, 'admin/categories');
        $category->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
