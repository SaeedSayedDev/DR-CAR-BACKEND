<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\CategoryInterface;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\File;

class CategoryRepository implements CategoryInterface
{
    public function index()
    {
        $categories = Category::with('items')->get();
        return response()->json([
            'data' => $categories
        ]);
    }

    public function store($request)
    {
        $requestData = request()->all();
        if ($request->has('image')) {
            $requestData['image'] = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs("public/images/admin/categories", $requestData['image']);
        }
        $category = Category::create($requestData);
        return response()->json([
            'message' => 'success',
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
        $requestData = request()->all();
        if ($request->has('image')) {
            if ($category->image) {
                $pathOldImage  = storage_path("app/public/images/admin/categories/" . $category->image);
                if (File::exists($pathOldImage)) {
                    unlink($pathOldImage);
                }
            }
                $requestData['image'] = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs("public/images/admin/categories", $requestData['image']);
        }
        $category->update($requestData);
        return response()->json([
            'message' => 'updated successfully',
            'data' => $category,
        ]);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        if ($category->image) {
            $pathOldImage  = storage_path("app/public/images/admin/categories/" . $category->image);
            if (File::exists($pathOldImage)) {
                unlink($pathOldImage);
            }
        }
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
