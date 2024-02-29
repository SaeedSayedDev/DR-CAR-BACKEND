<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\File;

class ImageService
{
    public function store($image, $folder, $type)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs("public/images/{$folder}", $imageName);
        return url("api/images/{$type}/{$imageName}");
    }

    public function update($imageName, $image, $folder, $type)
    {
        $this->delete($imageName, $folder);
        return $this->store($image, $folder, $type);
    }

    public function delete($imageName, $folder)
    {
        if ($imageName) {
            $imagePath  = storage_path("app/public/images/$folder/$imageName");
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }

    public function storeMedia($request, $type_id, $type, $path, $api_image)
    {
        if ($request->hasFile('images') or isset($request->images)) {
            $this->deleteMedia($type_id, $type, $path, $api_image);
            
            foreach ($request->images as $index => $image) {
                $data['image'] =  time() . $index . '.' . $image->extension();
                
                Media::create([
                    'image' => $api_image . '/' . $data['image'],
                    'type_id' => $type_id,
                    'type' => $type
                ]);
                $image->storeAs($path, $data['image']);
            }
        }
    }

    public function deleteMedia($type_id, $type, $path, $api_image)
    {
        if (request()->isMethod('put') || request()->isMethod('delete')) {
            $mediaDelete = Media::where('type_id', $type_id)->where('type', $type)->get();
            foreach ($mediaDelete as $media) {
                
                $media->delete();
                
                $directoryName = basename(parse_url($media->image, PHP_URL_PATH));
                $pathOldImage = storage_path("app/$path/" . $directoryName);
                if (File::exists($pathOldImage)) {
                    unlink($pathOldImage);
                }
            }
        }
    }
}
