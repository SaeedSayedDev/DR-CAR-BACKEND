<?php

namespace App\Http\Repositories\Admin;

use App\Http\Interfaces\Admin\ItemInterface;
use App\Models\Admin\Item;
use App\Services\ImageService;

class ItemRepository implements ItemInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $items = Item::with('media')->get();

        return response()->json([
            'data' => $items,
        ]);
    }


    public function show($id)
    {
        $item = Item::with('media')->findOrFail($id);

    
        return response()->json([
            'success' => true,
            'data' => $item,
            "message" => "Items retrieved successfully"
        ]);
    }


    public function store($request)
    {
        $requestData = $request->all();
        $item = Item::create([
            'category_id' => $requestData['category_id'],
        ]);

        $this->imageService->storeMedia($request, $item->id, 'item', 'public/images/admin/items' ,url("api/images/Item/"));

        foreach (['en', 'ar'] as $locale) {
            $item->translations()->create([
                'locale' => $locale,
                'name' => $requestData['name'][$locale],
                'desc' => $requestData['desc'][$locale],
            ]);
        }

        return response()->json([
            'message' => 'stored successfully',
            'data' => $item,
        ]);
    }

    public function update($request, $id)
    {
        $item = Item::findOrFail($id);
        $requestData = $request->all();

        $this->imageService->storeMedia($request, $item->id, 'item', 'public/images/admin/items', url("api/images/Item/"));

        $item->update([
            'category_id' => $requestData['category_id'],
        ]);

        foreach (['en', 'ar'] as $locale) {
            $item->translateOrNew($locale)->name = $requestData['name'][$locale];
            $item->translateOrNew($locale)->desc = $requestData['desc'][$locale];
        }
        $item->save();

        return response()->json([
            'message' => 'updated successfully',
            'data' => $item,
        ]);
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);
        // $this->imageService->delete($item, 'admin/items');
        $item->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
