<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class PdfService
{
    public function store($pdf, $folder)
    {
        $pdfName = time() . '.pdf';
        $pdf->storeAs("public/pdfs/{$folder}", $pdfName);
        return $pdfName;
    }

    public function update($pdfName, $pdf, $folder)
    {
        $this->delete($pdfName, $folder);
        return $this->store($pdf, $folder);
    }

    public function delete($pdfName, $folder)
    {
        if ($pdfName) {
            $pdfPath  = storage_path("app/public/pdfs/$folder/$pdfName");
            if (File::exists($pdfPath)) {
                File::delete($pdfPath);
            }
        }
    }
}
