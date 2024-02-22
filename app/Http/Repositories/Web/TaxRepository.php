<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\TaxInterface;
use App\Models\Taxe;

class TaxRepository implements TaxInterface
{
    public function index()
    {
        $taxes = Taxe::paginate(10);

        return view('settings.taxes.index', ['dataTable' => $taxes]);
    }

    public function create()
    {
        return view('settings.taxes.create');
    }
    
    public function store($request)
    {
        $validatedData = $request->validated();
        
        Taxe::create($validatedData);

        return redirect()->route('taxes.index');
    }

    public function edit($id)
    {
        $tax = Taxe::findOrFail($id);

        return view('settings.taxes.edit', compact('tax'));
    }

    public function update($request, $id)
    {
        $tax = Taxe::findOrFail($id);
        $validatedData = $request->validated();

        $tax->update($validatedData);

        return redirect()->route('taxes.index');
    }

    public function destroy($id)
    {
        $tax = Taxe::findOrFail($id);

        $tax->delete();

        return redirect()->route('taxes.index');
    }
}