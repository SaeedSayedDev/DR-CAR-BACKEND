<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ImageService
{
    const PATH = "public/images/";

    public function store($request, $folder = "temp", $file = 'image')
    {
        if ($request->has($file)) {
            $name = time() . '.' . $request->$file->extension();
            $request->file($file)->storeAs(self::PATH . $folder, $name);
            return $name;
        }
    }

    public function update($request, $model, $folder = "temp", $file = 'image')
    {
        if ($request->has($file)) {
            $this->delete($model, $folder, $file);
            return $this->store($request, $folder, $file);
        }
    }

    public function delete($model, $folder = "temp", $file = 'image')
    {
        if ($model->$file) {
            $pathOldImage  = storage_path('app/' . self::PATH . $folder . '/' . $model->$file);
            if (File::exists($pathOldImage)) {
                unlink($pathOldImage);
            }
        }
    }
}
