<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratApprovalMail;
use App\Mail\SuratSubmissionMail;
use App\Mail\SuratRejectionMail;

class TestAllEmailsCommand extends Command
{
    protected $signature = 'test:all-emails';
    protected $description = 'Test all email types (approval, submission, rejection)';

    public function handle()
    {
        $this->info('Testing all email types...');

        // Create dummy data for testing
        $surat = (object) [
            'id_surat' => 1,
            'nomor_surat' => 'TEST/001/VIII/2025',
            'status' => 'disetujui',
            'created_at' => now(),
            'updated_at' => now(),
            'jenisSurat' => (object) [
                'id_jenis' => 1,
                'nama_jenis' => 'Surat Keterangan Domisili'
            ]
        ];

        $pemohon = (object) [
            'id_pemohon' => 1,
            'nama_lengkap' => 'John Doe Test',
            'email' => 'test@example.com',
            'nik' => '1234567890123456',
            'alamat' => 'Jl. Test No. 123'
        ];

        $testEmail = 'test@example.com';

        try {
            // Test 1: Submission Email
            $this->info('1. Testing Submission Email...');
            Mail::to($testEmail)->send(new SuratSubmissionMail($surat, $pemohon));
            $this->info('   ✅ Submission email sent successfully!');

            // Test 2: Rejection Email
            $this->info('2. Testing Rejection Email...');
            $catatan = 'Data yang disubmit belum lengkap. Mohon melengkapi persyaratan yang diperlukan.';
            Mail::to($testEmail)->send(new SuratRejectionMail($surat, $pemohon, $catatan));
            $this->info('   ✅ Rejection email sent successfully!');

            // Test 3: Approval Email (without PDF for testing)
            $this->info('3. Testing Approval Email...');
            // Create a dummy PDF path for testing
            $dummyPdfPath = storage_path('app/temp/test_surat.pdf');

            // Create dummy PDF file if it doesn't exist
            if (!file_exists($dummyPdfPath)) {
                $this->createDummyPdf($dummyPdfPath);
            }

            Mail::to($testEmail)->send(new SuratApprovalMail($surat, $pemohon, $dummyPdfPath));
            $this->info('   ✅ Approval email sent successfully!');

            $this->info('');
            $this->info('🎉 All email types tested successfully!');
            $this->info('📧 Check your email inbox at: ' . $testEmail);
        } catch (\Exception $e) {
            $this->error('❌ Email test failed: ' . $e->getMessage());
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
