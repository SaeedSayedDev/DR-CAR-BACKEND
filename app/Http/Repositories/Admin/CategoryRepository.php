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
        $cateory_image_url = url("api/images/Category/");
        $Item_image_irl = url("api/images/Item/");

        return response()->json([
            'data' => $categories,
            'cateory_image_url' => $cateory_image_url,
            'Item_image_irl' => $Item_image_irl
        ]);
    }


    public function show($id)
    {
        $category = Category::findOrFail($id)->load('items.media', 'media');
        $cateory_image_url = url("api/images/Category/");
        $Item_image_irl = url("api/images/Item/");


        return response()->json([
            'data' => $category,
            'cateory_image_url' => $cateory_image_url,
            'Item_image_irl' => $Item_image_irl


        ]);
    }


    public function store($request)
    {
        $requestData = $request->all();

        $category = Category::create();

        $this->imageService->storeMedia($request, $category->id, 'category', 'public/images/admin/categories');


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

        $this->imageService->storeMedia($request, $category->id, 'category', 'public/images/admin/categories');

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
