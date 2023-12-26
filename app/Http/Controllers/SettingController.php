<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    //
    public function artisanOrder(Request $request)
    {
        $status = Artisan::call($request->order);
        return response()->json([$request['order'] => 'success', 'status' => $status]);
    }
    // public function Dotenv()
    // {
    //     dd(Dotenv\Dotenv::createArrayBacked(base_path())->load());
    // }
}