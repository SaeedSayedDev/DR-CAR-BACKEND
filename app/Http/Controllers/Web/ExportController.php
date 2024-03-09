<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\GarageData;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PDF;

class ExportController extends Controller
{
    public function exportPDF()
    {
        set_time_limit(180);

        $snappdf = new \Beganovich\Snappdf\Snappdf();

        $dataTable = GarageData::with([
            'user.garage_information', 'address', 'taxe', 'media'
        ])->paginate(10);
        $html = view('test', compact('dataTable'))->render();

        // Create Dompdf instance
        $options = [
            // 'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ];
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (optional)
        $dompdf->render();

        // Output PDF
        return $dompdf->stream('invoice.pdf');



        // $pdf = Pdf::loadView('e_providers.index', compact('dataTable'));
        // return $pdf->stream('invoice.pdf');
        // $pdf = PDF::loadView('e_providers.index', compact('dataTable'));
        // return $pdf->download('exported_data.pdf');

        // return view('e_providers.index', ['dataTable' => $eProviders]);
    }
}
