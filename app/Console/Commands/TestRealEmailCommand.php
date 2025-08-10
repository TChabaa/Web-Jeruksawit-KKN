<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratApprovalMail;
use App\Mail\SuratSubmissionMail;
use App\Mail\SuratRejectionMail;

class TestRealEmailCommand extends Command
{
    protected $signature = 'test:real-email {email}';
    protected $description = 'Test all email types with real email address';

    public function handle()
    {
        $email = $this->argument('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Please provide a valid email address');
            return 1;
        }

        $this->info("Testing email sending to real address: {$email}");

        // Create dummy data for testing
        $surat = (object) [
            'id_surat' => 999,
            'nomor_surat' => 'REAL/999/VIII/2025',
            'status' => 'disetujui',
            'created_at' => now(),
            'updated_at' => now(),
            'jenisSurat' => (object) [
                'id_jenis' => 1,
                'nama_jenis' => 'Surat Keterangan Domisili'
            ]
        ];

        $pemohon = (object) [
            'id_pemohon' => 999,
            'nama_lengkap' => 'Test User Real Email',
            'email' => $email,
            'nik' => '1234567890123456',
            'alamat' => 'Jl. Test Real Email No. 123'
        ];

        try {
            // Test Submission Email
            $this->info('📧 Sending Submission Email...');
            Mail::to($email)->send(new SuratSubmissionMail($surat, $pemohon));
            $this->info('   ✅ Submission email sent!');

            $this->info('');
            $this->info('🎉 Real email test completed successfully!');
            $this->info("📧 Check your inbox at: {$email}");
        } catch (\Exception $e) {
            $this->error('❌ Real email test failed: ' . $e->getMessage());

            // Check if it's an SMTP error
            if (strpos($e->getMessage(), 'SMTP') !== false) {
                $this->error('🔧 SMTP Configuration Issue Detected');
                $this->error('Please check:');
                $this->error('- MAIL_HOST: ' . config('mail.mailers.smtp.host'));
                $this->error('- MAIL_PORT: ' . config('mail.mailers.smtp.port'));
                $this->error('- MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
                $this->error('- MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
            }

            return 1;
        }

        return 0;
    }
}
