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
        $categories = Category::with('media')->withCount('items')->paginate(10);
        
        return view('categories.index', ['dataTable' => $categories]);
    }

    public function category($category)
    {
        $categories = Category::where('id', $category->id)->with('media')->withCount('items')->paginate(10);

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

        $category = Category::create($requestData);

        // store the other locale
        $requestData['locale'] = config('app.locale') === 'en' ? 'ar' : 'en';
        $category->translations()->create($requestData);

        if ($request->hasFile('image')) {
            $category->media()->create([
                'type' => 'category',
                'image' => $this->imageService->store($request->image, 'admin/categories', 'Category')
            ]);
        }

        return redirect()->route('categories.index')->with([
            'success' => trans('lang.created_success')
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
        $requestData['public'] = $request->filled('public');

        $category->update($requestData);
        if ($request->hasFile('image')) {
            $category->media()->updateOrCreate([
                'type' => 'category'
            ], [
                'image' => $this->imageService->update($category->media()->first()?->imageName(), $request->image, 'admin/categories', 'Category')
            ]);
        }

        return redirect()->route('categories.index')->with([
            'success' => trans('lang.updated_success')
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
       
        $this->imageService->delete($category->media()->first()?->imageName(), 'admin/categories');
        $category->media()->delete();
        $category->delete();

        return redirect()->route('categories.index')->with([
            'success' => trans('lang.deleted_success')
        ]);
    }
}
