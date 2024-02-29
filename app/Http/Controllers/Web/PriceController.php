<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::all();

        return view('prices.index', ['dataTable' => $prices]);
    }

    public function create()
    {
        return view('prices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['amount' => 'required|integer|min:0']);
        $data['type'] = 'ad';
        $data['per'] = 'day';

        Price::updateOrCreate($data);
    }
}
