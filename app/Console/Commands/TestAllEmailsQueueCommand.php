<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratApprovalMail;
use App\Mail\SuratSubmissionMail;
use App\Mail\SuratRejectionMail;

class TestAllEmailsQueueCommand extends Command
{
    protected $signature = 'test:all-emails-queue';
    protected $description = 'Test all email types with queue (approval, submission, rejection)';

    public function handle()
    {
        $this->info('Testing all email types with QUEUE...');

        // Create dummy data for testing
        $surat = (object) [
            'id_surat' => 2,
            'nomor_surat' => 'QUEUE/002/VIII/2025',
            'status' => 'disetujui',
            'created_at' => now(),
            'updated_at' => now(),
            'jenisSurat' => (object) [
                'id_jenis' => 1,
                'nama_jenis' => 'Surat Keterangan Usaha'
            ]
        ];

        $pemohon = (object) [
            'id_pemohon' => 2,
            'nama_lengkap' => 'Jane Doe Queue Test',
            'email' => 'queuetest@example.com',
            'nik' => '9876543210987654',
            'alamat' => 'Jl. Queue Test No. 456'
        ];

        $testEmail = 'queuetest@example.com';

        try {
            // Test 1: Queue Submission Email
            $this->info('1. Queueing Submission Email...');
            Mail::to($testEmail)->queue(new SuratSubmissionMail($surat, $pemohon));
            $this->info('   ✅ Submission email queued successfully!');

            // Test 2: Queue Rejection Email
            $this->info('2. Queueing Rejection Email...');
            $catatan = 'Dokumen pendukung belum sesuai format yang diperlukan. Silakan upload ulang dengan format PDF.';
            Mail::to($testEmail)->queue(new SuratRejectionMail($surat, $pemohon, $catatan));
            $this->info('   ✅ Rejection email queued successfully!');

            // Test 3: Queue Approval Email
            $this->info('3. Queueing Approval Email...');
            $dummyPdfPath = storage_path('app/temp/test_surat_queue.pdf');

            if (!file_exists($dummyPdfPath)) {
                $this->createDummyPdf($dummyPdfPath);
            }

            Mail::to($testEmail)->queue(new SuratApprovalMail($surat, $pemohon, $dummyPdfPath));
            $this->info('   ✅ Approval email queued successfully!');

            $this->info('');
            $this->info('🎉 All email types queued successfully!');
            $this->info('🔄 Run "php artisan queue:work --stop-when-empty" to process the queue');
            $this->info('📧 Emails will be sent to: ' . $testEmail);
        } catch (\Exception $e) {
            $this->error('❌ Email queue test failed: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }

    private function createDummyPdf($path)
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Create a simple dummy PDF content
        $pdfContent = "%PDF-1.4\n1 0 obj\n<<\n/Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n2 0 obj\n<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n3 0 obj\n<<\n/Type /Page\n/Parent 2 0 R\n/MediaBox [0 0 612 792]\n>>\nendobj\nxref\n0 4\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \ntrailer\n<<\n/Size 4\n/Root 1 0 R\n>>\nstartxref\n174\n%%EOF";
        file_put_contents($path, $pdfContent);
    }
}
