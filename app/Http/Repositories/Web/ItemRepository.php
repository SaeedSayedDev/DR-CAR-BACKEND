<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\ItemInterface;
use App\Models\Admin\Category;
use App\Models\Admin\Item;
use App\Services\ImageService;

class ItemRepository implements ItemInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $items = Item::paginate(10);
        return view('items.index', ['dataTable' => $items]);
    }

    public function create()
    {
        $categories = Category::select('id')->get();
        foreach ($categories as $category) {
            $form[$category->id] = $category->name;
        }
        return view('items.create', compact('form'));
    }

    public function store($request)
    {
        $requestData = $request->validated();
        $requestData['desc'] = strip_tags($request->input('desc'));

        $item = Item::create($requestData);
        if ($request->hasFile('image')) {
            $item->media()->create([
                'type' => 'item',
                'image' => $this->imageService->store($request->image, 'admin/items', 'Item')
            ]);
        }

        return redirect()->route('items.index')->with([
            'success' => 'Created successfully'
        ]);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::select('id')->get();
        foreach ($categories as $category) {
            $form[$category->id] = $category->name;
        }
        return view('items.edit', compact('item', 'form'));
    }

    public function update($request, $id)
    {
        $item = Item::findOrFail($id);
        $requestData = $request->validated();
        $requestData['desc'] = strip_tags($request->input('desc'));

        $item->update($requestData);
        if ($request->hasFile('image')) {
            $item->media()->updateOrCreate([
                'type' => 'item'
            ], [
                'image' => $this->imageService->update($item->media()->first()?->imageName(),  $request->image, 'admin/items', 'Item')
            ]);
        }

        return redirect()->route('items.index')->with([
            'success' => 'Updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $this->imageService->delete($item->media()->first()?->imageName(), 'admin/items');
        $item->media()->delete();
        $item->delete();
        
        return redirect()->route('items.index')->with([
            'success' => 'Deleted successfully'
        ]);
    }
}
