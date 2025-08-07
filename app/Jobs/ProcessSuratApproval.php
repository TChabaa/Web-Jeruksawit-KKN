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
            // Load surat with minimal required relationships only
            $surat = Surat::with(['pemohon:id_pemohon,nama_lengkap,email', 'jenisSurat:id_jenis,nama_jenis'])
                ->findOrFail($this->suratId);

            // Only process if still approved (status might have changed)
            if ($surat->status !== 'disetujui') {
                Log::info('Skipping PDF generation - surat status changed', ['surat_id' => $this->suratId]);
                return;
            }

            // Generate PDF with caching
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
     * Generate PDF with caching mechanism
     */
    private function generateCachedPdf($surat)
    {
        $cacheKey = "pdf_surat_{$surat->id_surat}_{$surat->updated_at->timestamp}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($surat) {
            $pdfController = new PDFController();
            return $pdfController->generateSuratPdf($surat);
        });
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
