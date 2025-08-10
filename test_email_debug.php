<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\SimpleTestMail;

// Test kirim email langsung tanpa queue
try {
    echo "Testing direct email send...\n";

    Mail::to('test@example.com')->send(new class extends \Illuminate\Mail\Mailable {
        public function build()
        {
            return $this->subject('Direct Test Email')
                ->html('<h1>Direct Test</h1><p>This email was sent directly without queue.</p>');
        }
    });

    echo "Direct email sent successfully!\n";
} catch (Exception $e) {
    echo "Direct email failed: " . $e->getMessage() . "\n";
}

// Test kirim email dengan queue
try {
    echo "\nTesting queued email send...\n";

    Mail::to('test@example.com')->queue(new SimpleTestMail());

    echo "Queued email dispatched successfully!\n";
} catch (Exception $e) {
    echo "Queued email failed: " . $e->getMessage() . "\n";
}

echo "\nChecking queue status...\n";
$pendingJobs = \Illuminate\Support\Facades\DB::table('jobs')->where('queue', 'emails')->count();
echo "Pending jobs in emails queue: $pendingJobs\n";

echo "\nChecking failed jobs...\n";
$failedJobs = \Illuminate\Support\Facades\DB::table('failed_jobs')->count();
echo "Failed jobs: $failedJobs\n";
