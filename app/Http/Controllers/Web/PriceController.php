<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::paginate(10);

        return view('prices.index', ['dataTable' => $prices]);
    }

    public function edit(Price $price)
    {
        return view('prices.edit', compact('price'));
    }

    public function update(Request $request, Price $price)
    {
        $data = $request->validate(['amount' => 'required|integer|min:0']);

        $price->update($data);

        return redirect()->route('prices.index')->withSuccess(trans('lang.updated_success'));
    }
}
