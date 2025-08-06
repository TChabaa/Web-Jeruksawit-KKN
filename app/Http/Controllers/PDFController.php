<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [

            'nomor' => '185',
            'tahun' => '2025',
            'nama_kepala' => 'MIDI',
            'nama1' => 'SUPATA',
            'ttl1' => 'Karanganyar, 09-05-1981',
            'nik1' => '3313110905810002',
            'ayah1' => 'KASNO',
            'alamat1' => 'Jeruksawit, RT.005/006, Desa Jeruksawit, Kec. Gondangrejo',
            'kk' => '3313131809130005',
            'nama2' => 'SUYANTO',
            'ttl2' => 'Karanganyar, 09-05-1981',
            'ayah2' => 'PARIMIN',
            'buku_nikah' => '528/33/X/2009',
            'tanggal' => '03 Maret 2025'
        ];
        $customPaper = [0, 0, 595.276, 935.433];
        // Validate the request data
        $pdf = Pdf::loadView('components.surat.orang_yang_sama_pdf', $data)->setPaper($customPaper, 'portrait');

        return $pdf->download('surat_orang_yang_sama.pdf');
    }
}
