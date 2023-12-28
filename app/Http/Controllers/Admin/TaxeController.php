<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taxe;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    //

    function index()
    {
        return response()->json(['data' => Taxe::get()]);
    }
}
