<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\SlideInterface;
use App\Models\Admin\Service;
use App\Models\Slide;
use App\Services\ImageService;

class SlideRepository implements SlideInterface
{
    function __construct(private ImageService $imageService)
    {
    }

    public function index()
    {
        $slides = Slide::with('service')->paginate(10);

        return view('slides.index', ['dataTable' => $slides]);
    }
    
    public function create()
    {
        $eService  = Service::pluck('name', 'id')->toArray();

        return view('slides.create', compact('eService'));
    }
    
    public function store($request)
    {
        $requestData = $request->validated();

        $category = Slide::create($requestData);
        if ($request->hasFile('image')) {
            $category->media()->create([
                'type' => 'slide',
                'image' => $this->imageService->store($request->image, 'admin/slides', 'Slide')
            ]);
        }

        return redirect()->route('slides.index')->with([
            'success' => 'Created successfully'
        ]);
    }
    
    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        $eService  = Service::pluck('name', 'id')->toArray();

        return view('slides.edit', compact('slide', 'eService'));
    }

    public function update($request, $id)
    {
        $slide = Slide::findOrFail($id);
        $requestData = $request->validated();

        $slide->update($requestData);
        if ($request->hasFile('image')) {
            $slide->media()->updateOrCreate([
                'type' => 'slide'
            ], [
                'image' => $this->imageService->update($slide->media()->first()?->imageName(),  $request->image, 'admin/slides', 'Slide')
            ]);
        }

        return redirect()->route('slides.index')->with([
            'success' => 'Updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $slide = Slide::findOrFail($id);

        $this->imageService->delete($slide->media()->first()?->imageName(), 'admin/slides');
        $slide->media()->delete();
        $slide->delete();
        
        return redirect()->route('slides.index')->with([
            'success' => 'Deleted successfully'
        ]);
    }
}
