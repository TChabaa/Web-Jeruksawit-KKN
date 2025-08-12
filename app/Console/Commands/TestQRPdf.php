<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PDFController;
use App\Models\Surat;

class TestQRPdf extends Command
{
    protected $signature = 'test:qr-pdf {surat_id}';
    protected $description = 'Test QR code generation in PDF';

    public function handle()
    {
        $suratId = $this->argument('surat_id');

        try {
            $surat = Surat::with(['pemohon', 'jenisSurat'])->findOrFail($suratId);

            if ($surat->status !== 'disetujui') {
                $this->error('Surat must be approved (disetujui) to generate PDF with QR code');
                return;
            }

            $pdfController = new PDFController();
            $pdfPath = $pdfController->generateSuratPdf($surat);

            $this->info("PDF generated successfully: {$pdfPath}");
            $this->info("QR verification URL: " . route('qr.verify', $surat->id_surat));
            $this->info("PDF viewer URL: " . route('pdf.viewer', $surat->id_surat));
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
