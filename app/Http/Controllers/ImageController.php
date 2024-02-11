<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    function imageCategory($name)
    {
        try {
            return response()->file("../storage/app/public/images/admin/categories/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }




    function imageItem($name)
    {
        try {
            return response()->file("../storage/app/public/images/admin/items/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }

    function imageService($name)
    {
        try {
            return response()->file("../storage/app/public/images/admin/services/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }
    function imageReceive($name)
    {
        try {
            return response()->file("../storage/app/public/images/admin/receives/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }


    function imageProvider($name)
    {
        try {
            return response()->file("../storage/app/public/images/accounts/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }
    function imageGarage($name)
    {
        try {
            return response()->file("../storage/app/public/images/providers/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }

    function imageSlide($name)
    {
        try {
            return response()->file("../storage/app/public/images/admin/slides/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }

    function imageOptions($name)
    {
        try {
            return response()->file("../storage/app/public/images/options/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
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
