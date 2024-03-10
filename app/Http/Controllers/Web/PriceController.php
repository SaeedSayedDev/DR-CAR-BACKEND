<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\PriceRequest;
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

    public function update(PriceRequest $request, Price $price)
    {
        $data = $request->validated();

        $price->update($data);

        return redirect()->route('prices.index')->withSuccess(trans('lang.updated_success'));
    }
}
