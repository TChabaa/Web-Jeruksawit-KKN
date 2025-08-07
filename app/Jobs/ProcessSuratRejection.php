<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Surat;
use App\Mail\SuratRejectionMail;

class ProcessSuratRejection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $suratId;
    protected $catatan;
    public $tries = 3;
    public $backoff = [5, 15, 30]; // Retry after 5s, 15s, 30s (faster for rejection emails)

    /**
     * Create a new job instance.
     */
    public function __construct($suratId, $catatan = null)
    {
        $this->suratId = $suratId;
        $this->catatan = $catatan;
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

            // Only process if still rejected (status might have changed)
            if ($surat->status !== 'ditolak') {
                Log::info('Skipping rejection email - surat status changed', ['surat_id' => $this->suratId]);
                return;
            }

            // Send rejection email
            Mail::to($surat->pemohon->email)->send(new SuratRejectionMail($surat, $surat->pemohon, $this->catatan));

            Log::info('Surat rejection email sent successfully', [
                'surat_id' => $this->suratId,
                'email' => $surat->pemohon->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email', [
                'surat_id' => $this->suratId,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Surat rejection job failed permanently', [
            'surat_id' => $this->suratId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
