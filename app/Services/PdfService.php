<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\File;

class PdfService
{
    public function storeMedia($request, $type_id, $type, $path, $api_pdf)
    {
        if ($request->hasFile('pdf') or isset($request->pdf)) {
            $this->deleteMedia($type_id, $type, $path, $api_pdf);
            $data['pdf'] =  time() . '.' . $request->pdf->extension();
            Media::create([
                'image' => $api_pdf . '/' . $data['pdf'],
                'type_id' => $type_id,
                'type' => $type
            ]);
            $request->pdf->storeAs($path, $data['pdf']);
        }
    }

    public function deleteMedia($type_id, $type, $path, $api_pdf)
    {
        if (request()->isMethod('put') || request()->isMethod('delete')) {
            $mediaDelete = Media::where('type_id', $type_id)->where('type', $type)->get();
            foreach ($mediaDelete as $media) {

                $media->delete();

                $directoryName = basename(parse_url($media->pdf, PHP_URL_PATH));
                $pathOldpdf = storage_path("app/$path/" . $directoryName);
                if (File::exists($pathOldpdf)) {
                    unlink($pathOldpdf);
                }
            }
        }
    }
}
