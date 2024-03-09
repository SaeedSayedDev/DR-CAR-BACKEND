<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ImageRequest;
use App\Models\Media;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function index()
    {
        $images = Media::where('type_id', 0)->get();

        return view('images.index', ['dataTable' => $images]);
    }

    public function update(ImageRequest $request, Media $image)
    {
        $newImage = $request->image;

        $imageName = $image->imageName();
        $imagePath  = storage_path("app/public/images/app/$imageName");
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }

        $newImageName = time() . '.' . $request->image->getClientOriginalExtension();
        $newImage->storeAs("public/images/app", $newImageName);

        $image->update(['image' => url("api/images/App/$newImageName")]);

        return redirect()->route('images.index')->withSuccess(trans('lang.updated_success'));
    }
}
