<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show($type, $name)
    {
        $folder = match ($type) {
            'Category' => "admin/categories",
            'Item' => "admin/items",
            'Service' => "admin/services",
            'Receive' => "admin/receives",
            'Slide' => "admin/slides",
            'Options' => "admin/options",
            'Provider' => "accounts",
            'Garage' => "providers",
            'Ad' => 'ads',
            'CarLicense' => 'admin/cars/licenses',
            'Report' => 'car_reports',
            default => null,
        };

        if (!$folder) {
            return response()->json(['message' => "Invalid image type: $type"], 400);
        }

        try {
            return response()->file("../storage/app/public/images/$folder/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This file $name is not found"], 404);
        }
    }

    function imageDefault()
    {
        try {
            return response()->file("../storage/app/public/images/image_default.jpeg");
        } catch (Exception $e) {
            return response()->json(['message' => "image default Is Not Found"], 404);
        }
    }

    function getImageDefault()
    {
        try {
            $imageUrl = url("api/images/image_default/");
            return response()->json(['success' => true, 'data' => $imageUrl]);
        } catch (Exception $e) {
            return response()->json(['message' => "image default Is Not Found"], 404);
        }
    }

 
    
}
