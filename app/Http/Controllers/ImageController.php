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
    function imageService($name)
    {
        try {
            return response()->file("../storage/app/public/images/admin/services/$name");
        } catch (Exception $e) {
            return response()->json(['message' => "This File $name Is Not Found"], 404);
        }
    }
    
}
