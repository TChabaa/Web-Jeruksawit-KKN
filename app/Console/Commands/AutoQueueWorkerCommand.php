<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoQueueWorkerCommand extends Command
{
    protected $signature = 'queue:auto-worker
                            {--daemon : Run as daemon}
                            {--max-runtime=1800 : Maximum runtime in seconds}';

    protected $description = 'Auto-running queue worker for cPanel hosting environments';

    public function handle()
    {
        $isDaemon = $this->option('daemon');
        $maxRuntime = (int) $this->option('max-runtime');
        $startTime = time();

        // Prevent duplicate workers using cache lock
        if (!Cache::add('queue_auto_worker_lock', true, 60)) {
            $this->info('⚠ Another worker is already running. Exiting.');
            return 0;
        }

        $this->info('🚀 Starting Auto Queue Worker');
        $this->info('📧 Will process until queue is empty.');

        try {
            while (true) {
                // Stop if max runtime exceeded
                if ((time() - $startTime) > $maxRuntime) {
                    $this->info('⏱ Max runtime reached, stopping worker.');
                    break;
                }

                // Check if there are any pending jobs in the database
                $jobCount = DB::table('jobs')
                    ->where('queue', 'emails')
                    ->count();

                if ($jobCount === 0) {
                    $this->info('✅ Queue is empty.');
                    if (!$isDaemon) break;

                    sleep(5);
                    continue;
                }

                // Process all jobs until queue is empty
                $this->info("📦 Found {$jobCount} jobs. Processing...");
                Artisan::call('queue:work', [
                    '--queue' => 'emails',
                    '--timeout' => 120,
                    '--memory' => 256,
                    '--sleep' => 3,
                    '--stop-when-empty' => true, // Laravel will process until empty
                ]);

                Log::info("Queue worker processed {$jobCount} jobs.");

                if (!$isDaemon) break;
            }
        } catch (\Exception $e) {
            Log::error('Queue worker error: ' . $e->getMessage());
            $this->error('Queue worker error: ' . $e->getMessage());
        } finally {
            // Release lock
            Cache::forget('queue_auto_worker_lock');
        }

        return 0;
    }
}
