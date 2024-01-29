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
}