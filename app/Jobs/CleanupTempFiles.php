<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupTempFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->cleanupPdfFiles();
            $this->cleanupTempDirectories();
            $this->cleanupLogFiles();

            Log::info('Temporary files cleanup completed successfully');
        } catch (\Exception $e) {
            Log::error('Failed to cleanup temporary files: ' . $e->getMessage());
        }
    }

    /**
     * Clean up old PDF files
     */
    private function cleanupPdfFiles(): void
    {
        $pdfDirectory = storage_path('app/public/surat-pdf');

        if (!is_dir($pdfDirectory)) {
            return;
        }

        $files = glob($pdfDirectory . '/*.pdf');
        $deletedCount = 0;

        foreach ($files as $file) {
            // Delete files older than 7 days
            if (filemtime($file) < Carbon::now()->subDays(7)->timestamp) {
                if (unlink($file)) {
                    $deletedCount++;
                }
            }
        }

        Log::info("Cleaned up {$deletedCount} old PDF files");
    }

    /**
     * Clean up temporary directories
     */
    private function cleanupTempDirectories(): void
    {
        $tempPaths = [
            storage_path('app/temp'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
        ];

        foreach ($tempPaths as $path) {
            if (is_dir($path)) {
                $this->cleanupDirectory($path, 1); // Clean files older than 1 day
            }
        }
    }

    /**
     * Clean up log files
     */
    private function cleanupLogFiles(): void
    {
        $logDirectory = storage_path('logs');
        $files = glob($logDirectory . '/*.log');

        foreach ($files as $file) {
            // Keep only last 30 days of logs
            if (filemtime($file) < Carbon::now()->subDays(30)->timestamp) {
                unlink($file);
            }
        }
    }

    /**
     * Clean up directory contents
     */
    private function cleanupDirectory(string $directory, int $daysOld): void
    {
        $files = glob($directory . '/*');

        foreach ($files as $file) {
            if (is_file($file) && filemtime($file) < Carbon::now()->subDays($daysOld)->timestamp) {
                unlink($file);
            } elseif (is_dir($file)) {
                $this->cleanupDirectory($file, $daysOld);
                // Remove empty directories
                if (count(glob($file . '/*')) === 0) {
                    rmdir($file);
                }
            }
        }
    }
}
