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
        $categories = Category::with('items.media', 'media')->get();

        return response()->json([
            'data' => $categories,
        ]);
    }


    public function show($id)
    {
        $category = Category::findOrFail($id)->load('items.media', 'media');


        return response()->json([
            'data' => $category,


        ]);
    }


    public function store($request)
    {
        $requestData = $request->all();

        $category = Category::create();

        $this->imageService->storeMedia($request, $category->id, 'category', 'public/images/admin/categories', url("api/images/Category/"));


        foreach (['en', 'ar'] as $locale) {
            $category->translations()->create([
                'locale' => $locale,
                'name' => $requestData['name'][$locale],
                'desc' => $requestData['desc'][$locale],
            ]);
        }

        return response()->json([
            'message' => 'stored successfully',
            'data' => $category,

        ]);
    }



    public function update($request, $id)
    {
        $category = Category::findOrFail($id);
        $requestData = $request->all();

        $this->imageService->storeMedia($request, $category->id, 'category', 'public/images/admin/categories', url("api/images/Category/"));

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
        $category->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
