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
        $categories = Category::with('items.media', 'media')->get()
            ->map(function ($category) {
                return  $this->handelTranslatable($category);
            });
        return response()->json([
            'success' => true,
            'data' =>  $categories,
            "message" => "Categories retrieved successfully"
        ]);
    }

    public function handelTranslatable($data)
    {
        $name_en = isset($data->translate('en')->name) ? $data->translate('en')->name : '';
        $name_ar = isset($data->translate('ar')->name) ? $data->translate('ar')->name : '';

        $desc_en = isset($data->translate('en')->desc) ? $data->translate('en')->desc : '';
        $desc_ar = isset($data->translate('ar')->desc) ? $data->translate('ar')->desc : '';

        $array = ['en' => $name_en, 'ar' => $name_ar];
        $data->name = (object) $array;

        $array = ['en' => $desc_en, 'ar' => $desc_ar];
        $data->desc = (object) $array;

        return $data;
    }
    public function show($id)
    {
        $category = Category::findOrFail($id)->load('items.media', 'media');
        $category = $this->handelTranslatable($category);

        return response()->json([
            'success' => true,
            'data' => $category,
            "message" => "Category retrieved successfully"
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
        $imageUrl = url("api/images/Category/");

        return response()->json([
            'message' => 'stored successfully',
            'data' => $category,
            'image_url' => $imageUrl
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
