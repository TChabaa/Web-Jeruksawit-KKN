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
use App\Models\Pemohon;
use App\Mail\SuratSubmissionMail;

class ProcessSuratSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $suratId;
    protected $pemohonId;
    public $tries = 3;
    public $backoff = [5, 15, 30];

    /**
     * Create a new job instance.
     */
    public function __construct($suratId, $pemohonId)
    {
        $this->suratId = $suratId;
        $this->pemohonId = $pemohonId;
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load models with minimal relationships
            $surat = Surat::with(['jenisSurat:id_jenis,nama_jenis'])
                ->findOrFail($this->suratId);

            $pemohon = Pemohon::select('id_pemohon', 'nama_lengkap', 'email')
                ->findOrFail($this->pemohonId);

            // Send submission confirmation email
            Mail::to($pemohon->email)->send(new SuratSubmissionMail($surat, $pemohon));

            Log::info('Surat submission email sent successfully', [
                'surat_id' => $this->suratId,
                'email' => $pemohon->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send submission email', [
                'surat_id' => $this->suratId,
                'pemohon_id' => $this->pemohonId,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Surat submission job failed permanently', [
            'surat_id' => $this->suratId,
            'pemohon_id' => $this->pemohonId,
            'error' => $exception->getMessage()
        ]);
    }
}
