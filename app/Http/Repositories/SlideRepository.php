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
        $slides = Slide::with('media')->get();

        return response()->json([
            'success' => true,
            'data' => $slides,
            "message" => "Slide retrieved successfully"
        ]);
    }

    public function store($request)
    {
        $requestData = $request->all();
        $slide = Slide::create($requestData);

        $this->imageService->storeMedia($request, $slide->id, 'slide', 'public/images/admin/slides', url("api/images/Slide/"));

        return response()->json([
            'message' => 'stored successfully',
            'data' => $slide,
        ]);
    }

    public function show($id)
    {
        $slide = Slide::with('service.provider', 'media')->findOrFail($id);

        return response()->json([
            'data' => $slide,

        ]);
    }

    public function update($request, $id)
    {
        $slide = Slide::findOrFail($id);
        $requestData = $request->all();
        $this->imageService->storeMedia($request, $slide->id, 'slide', 'public/images/admin/slides', url("api/images/Slide/"));
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
