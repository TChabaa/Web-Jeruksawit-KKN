<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Surat;
use App\Mail\SuratApprovalMail;
use App\Http\Controllers\PDFController;

class ProcessSuratApproval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $suratId;
    public $tries = 3;
    public $backoff = [10, 30, 60]; // Retry after 10s, 30s, 60s

    /**
     * Create a new job instance.
     */
    public function __construct($suratId)
    {
        $this->suratId = $suratId;
        $this->onQueue('emails'); // Use dedicated queue for email processing
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load surat with all required relationships for PDF generation (same as web download)
            $surat = Surat::with(['pemohon', 'jenisSurat'])
                ->findOrFail($this->suratId);

            // Log the loaded data to verify completeness
            Log::info('ProcessSuratApproval: Loaded surat data for email PDF', [
                'surat_id' => $surat->id_surat,
                'pemohon_name' => $surat->pemohon->nama_lengkap ?? 'NULL',
                'pemohon_nik' => $surat->pemohon->nik ?? 'NULL',
                'pemohon_tempat_lahir' => $surat->pemohon->tempat_lahir ?? 'NULL',
                'pemohon_tanggal_lahir' => $surat->pemohon->tanggal_lahir ?? 'NULL',
                'pemohon_nomor_kk' => $surat->pemohon->nomor_kk ?? 'NULL',
                'jenis_surat' => $surat->jenisSurat->nama_jenis ?? 'NULL'
            ]);

            // Only process if still approved (status might have changed)
            if ($surat->status !== 'disetujui') {
                Log::info('Skipping PDF generation - surat status changed', ['surat_id' => $this->suratId]);
                return;
            }

            // Generate PDF using the same method as web download
            $pdfPath = $this->generateCachedPdf($surat);

            // Send email
            Mail::to($surat->pemohon->email)->send(new SuratApprovalMail($surat, $surat->pemohon, $pdfPath));

            Log::info('Surat approval processed successfully', [
                'surat_id' => $this->suratId,
                'email' => $surat->pemohon->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to process surat approval', [
                'surat_id' => $this->suratId,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Generate PDF with caching mechanism (same as show page download)
     */
    private function generateCachedPdf($surat)
    {
        // Use the same cache key structure as PDFController for consistency
        $cacheKey = "pdf_path_surat_{$surat->id_surat}_{$surat->updated_at->timestamp}";

        // Check if PDF already exists in cache (same logic as PDFController)
        $existingPdfPath = Cache::get($cacheKey);
        if ($existingPdfPath && file_exists($existingPdfPath)) {
            Log::info('Using cached PDF for email', ['surat_id' => $surat->id_surat, 'path' => $existingPdfPath]);
            return $existingPdfPath;
        }

        // Use the exact same method as show page download
        // This ensures 100% consistency with web download
        $pdfController = new PDFController();

        // Call the same generateSuratPdf method that the show page uses internally
        $pdfPath = $pdfController->generateSuratPdf($surat);

        Log::info('Generated PDF for email using same method as show page', [
            'surat_id' => $surat->id_surat,
            'path' => $pdfPath
        ]);

        return $pdfPath;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Surat approval job failed permanently', [
            'surat_id' => $this->suratId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
