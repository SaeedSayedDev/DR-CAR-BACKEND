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
        $items = Item::all();
        return response()->json([
            'data' => $items
        ]);
    }

    public function store($request)
    {
        $requestData = $request->all();
        $requestData['image'] = $this->imageService->store($request, 'admin/items');

        $item = Item::create([
            'image' => $requestData['image'],
            'category_id' => $requestData['category_id'],
        ]);
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
        $requestData = $request->all();
        $requestData['image'] = $this->imageService->update($request, $item, 'admin/items');

        $item->update([
            'image' => $requestData['image'],
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
        $this->imageService->delete($item, 'admin/items');
        $item->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
