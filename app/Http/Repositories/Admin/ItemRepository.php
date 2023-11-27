<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\ItemInterface;
use App\Models\Admin\Item;
use Illuminate\Support\Facades\File;

class ItemRepository implements ItemInterface
{
    public function index()
    {
        $items = Item::all();
        return response()->json([
            'data' => $items
        ]);
    }

    public function store($request)
    {
        $requestData = request()->all();
        if ($request->has('image')) {
            $requestData['image'] = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs("public/images/admin/items", $requestData['image']);
        }
        $item = Item::create($requestData);
        return response()->json([
            'message' => 'success',
        ]);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json([
            'data' => $item
        ]);
    }

    public function update($request, $id)
    {
        $item = Item::findOrFail($id);
        $requestData = request()->all();
        if ($request->has('image')) {
            if ($item->image) {
                $pathOldImage  = storage_path("app/public/images/admin/items/" . $item->image);
                if (File::exists($pathOldImage)) {
                    unlink($pathOldImage);
                }
            }
            $requestData['image'] = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs("public/images/admin/items", $requestData['image']);
        }
        $item->update($requestData);
        return response()->json([
            'message' => 'success',
        ]);
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        if ($item->image) {
            $pathOldImage  = storage_path("app/public/images/admin/items/" . $item->image);
            if (File::exists($pathOldImage)) {
                unlink($pathOldImage);
            }
        }
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
