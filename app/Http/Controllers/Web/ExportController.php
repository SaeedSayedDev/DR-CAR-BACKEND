<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\GarageData;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class ExportController extends Controller
{
    public function exportPDF()
    {
        $dataTable = GarageData::with([
            'user.garage_information', 'address', 'taxe', 'media'
        ])->paginate(10);
        $pdf = PDF::loadView('e_providers.index', compact('dataTable'));
        return $pdf->download('exported_data.pdf');

        // return view('e_providers.index', ['dataTable' => $eProviders]);
    }
}
