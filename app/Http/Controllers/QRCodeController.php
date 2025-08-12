<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function show($suratId)
    {
        $surat = Surat::with(['pemohon', 'jenisSurat'])->findOrFail($suratId);

        return view('components.pages.frontend.verify', [
            'surat' => $surat,
            'pdfPath' => route('pdf.viewer', $surat->id_surat) // link untuk PDF.js
        ]);
    }
}
