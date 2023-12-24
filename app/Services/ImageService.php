<?php

namespace App\Services;

use App\Models\ImagesService;
use App\Models\ImagesUsers;
use App\Models\Media;
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

    public function storeMedia($request, $type_id, $type, $path)
    {
        if ($request->hasFile('images')) {
            $this->deleteMedia($type_id, $type, $path);

            foreach ($request->images as $index => $image) {
                $data['image'] = time() . $index . '.' . $image->extension();
                Media::create([
                    'image' => $data['image'],
                    'type_id' => $type_id,
                    'type' => $type
                ]);
                $image->storeAs($path, $data['image']);
            }
        }
    }

    public function deleteMedia($type_id, $type, $path)
    {
        if (request()->isMethod('put')) {
            $mediaDelete = Media::where('type_id', $type_id)->where('type', $type)->get();
            foreach ($mediaDelete as $media) {
                $pathOldImage = storage_path("app/$path/" . $media->image);
                if (File::exists($pathOldImage)) {
                    unlink($pathOldImage);
                    $media->delete();
                }
            }
        }
    }
}
