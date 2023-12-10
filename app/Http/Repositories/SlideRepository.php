<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\SlideInterface;
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
        $slides = Slide::all();
        return response()->json([
            'data' => $slides
        ]);
    }

    public function store($request)
    {
        $requestData = $request->all();
        $requestData['image'] = $this->imageService->store($request, 'slides');
        $slide = Slide::create($requestData);
        return response()->json([
            'message' => 'stored successfully',
            'data' => $slide,
        ]);
    }

    public function show($id)
    {
        $slide = Slide::findOrFail($id);
        $service = Service::find($slide->service_id);
        return response()->json([
            'data' => $service
        ]);
    }

    public function update($request, $id)
    {
        $slide = Slide::findOrFail($id);
        $requestData = $request->all();
        $requestData['image'] = $this->imageService->update($request, $slide, 'slides');
        $slide->update($requestData);
        return response()->json([
            'message' => 'updated successfully',
            'data' => $slide,
        ]);
    }

    public function delete($id)
    {
        $slide = Slide::findOrFail($id);
        $this->imageService->delete($slide, 'slides');
        $slide->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
