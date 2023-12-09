<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ImageService
{
    const PATH = "public/images/";

    public function store($request, $folder = "temp")
    {
        if ($request->has('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->file('image')->storeAs(self::PATH . $folder, $image);
            return $image;
        }
    }

    public function update($request, $model, $folder = "temp")
    {
        if ($request->has('image')) {
            $this->delete($model, $folder);
            return $this->store($request, $folder);
        }
    }

    public function delete($model, $folder = "temp")
    {
        if ($model->image) {
            $pathOldImage  = storage_path('app/' . self::PATH . $folder . '/' . $model->image);
            if (File::exists($pathOldImage)) {
                unlink($pathOldImage);
            }
        }
    }
}
