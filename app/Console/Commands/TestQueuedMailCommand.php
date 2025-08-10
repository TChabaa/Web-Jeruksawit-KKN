<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratSubmissionMail;
use App\Models\User;

class TestQueuedMailCommand extends Command
{
    protected $signature = 'test:queued-mail';
    protected $description = 'Test queued email functionality';

    public function handle()
    {
        try {
            // Create a dummy surat object for testing
            $surat = (object) [
                'id' => 1,
                'jenisSurat' => (object) ['nama_jenis' => 'Test Surat'],
                'no_surat' => 'TEST/001/2025',
                'created_at' => now()
            ];

            $pemohon = (object) [
                'nama_lengkap' => 'Test User',
                'email' => 'testuser@example.com',
                'nik' => '1234567890123456'
            ];

            // Send without queuing first to test if template works
            $mailable = new SuratSubmissionMail($surat, $pemohon);

            // Remove queuing for testing
            $mailable = $mailable->onConnection('sync');

            Mail::to('test@example.com')->send($mailable);

            $this->info('Email sent successfully (without queue)!');
            $this->info('Now testing with queue...');

            // Now test with queue
            Mail::to('test@example.com')->queue(new SuratSubmissionMail($surat, $pemohon));

            $this->info('Queued email dispatched successfully!');
            $this->info('Check your queue to see if the job was added.');
            $this->info('Run "php artisan queue:work" to process the queue.');
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }
    }
}
