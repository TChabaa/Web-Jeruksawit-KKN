<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\SuratSubmissionMail;

class EmailQueueController extends Controller
{
    /**
     * Display queue status and management interface
     */
    public function index()
    {
        $stats = [
            'pending_jobs' => DB::table('jobs')->where('queue', 'emails')->count(),
            'failed_jobs' => DB::table('failed_jobs')->count(),
            'total_processed' => DB::table('jobs')->where('queue', 'emails')->count(),
        ];

        return view('admin.email-queue', compact('stats'));
    }

    /**
     * Process queue manually (for cPanel environments)
     */
    public function processQueue(Request $request)
    {
        try {
            // Process a limited number of jobs to avoid timeout
            $jobsProcessed = 0;
            $maxJobs = 10; // Limit to prevent timeout

            for ($i = 0; $i < $maxJobs; $i++) {
                $result = Artisan::call('queue:work', [
                    '--once' => true,
                    '--queue' => 'emails',
                    '--timeout' => 60,
                    '--memory' => 128,
                ]);

                if ($result === 0) {
                    $jobsProcessed++;
                } else {
                    break; // No more jobs to process
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Processed {$jobsProcessed} email(s) successfully",
                'jobs_processed' => $jobsProcessed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing queue: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test email functionality
     */
    public function testEmail(Request $request)
    {
        try {
            $testData = [
                'id' => 999,
                'jenisSurat' => (object) ['nama_jenis' => 'Test Email'],
                'no_surat' => 'TEST/001/2025',
                'created_at' => now()
            ];

            $testPemohon = [
                'nama_lengkap' => 'Test User',
                'email' => $request->input('email', 'test@example.com'),
                'nik' => '1234567890123456'
            ];

            // Convert arrays to objects
            $surat = (object) $testData;
            $pemohon = (object) $testPemohon;

            // Send test email
            Mail::to($pemohon->email)->send(new SuratSubmissionMail($surat, $pemohon));

            return response()->json([
                'success' => true,
                'message' => 'Test email queued successfully to ' . $pemohon->email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending test email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear failed jobs
     */
    public function clearFailedJobs()
    {
        try {
            Artisan::call('queue:flush');

            return response()->json([
                'success' => true,
                'message' => 'Failed jobs cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing failed jobs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get queue statistics
     */
    public function getStats()
    {
        try {
            $stats = [
                'pending_jobs' => DB::table('jobs')->where('queue', 'emails')->count(),
                'failed_jobs' => DB::table('failed_jobs')->count(),
                'last_processed' => DB::table('jobs')
                    ->where('queue', 'emails')
                    ->orderBy('created_at', 'desc')
                    ->value('created_at'),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting stats: ' . $e->getMessage()
            ], 500);
        }
    }
}
