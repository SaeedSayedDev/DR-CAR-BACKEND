<?php

namespace App\Http\Repositories\Web;

use App\Http\Interfaces\Web\CommissionInterface;
use App\Models\Commission;

class CommissionRepository implements CommissionInterface
{
    public function index()
    {
        $commissions = Commission::paginate(10);
        return view('settings.commissions.index', ['dataTable' => $commissions]);
    }

    public function edit($id)
    {
        $commission = Commission::findOrFail($id);
        return view('settings.commissions.edit', compact('commission'));
    }

    public function update($request, $id)
    {
        $commission = Commission::findOrFail($id);
        $requestData = $request->validated();
        $commission->update($requestData);
        return redirect()->route('commissions.index');
    }
}