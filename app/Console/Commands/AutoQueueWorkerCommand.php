<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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

        $this->info('🚀 Starting Auto Queue Worker for cPanel Environment');
        $this->info('📧 Processing email queue without terminal dependency...');

        while (true) {
            try {
                // Process jobs one by one
                $result = Artisan::call('queue:work', [
                    '--once' => true,
                    '--queue' => 'emails',
                    '--timeout' => 120,
                    '--memory' => 256,
                    '--sleep' => 3,
                ]);

                // Log successful processing
                if ($result === 0) {
                    Log::info('Queue worker processed job successfully');
                } else {
                    Log::warning('Queue worker completed with status: ' . $result);
                }

                // Check if we should stop (for non-daemon mode or time limit)
                if (!$isDaemon || (time() - $startTime) > $maxRuntime) {
                    $this->info('✅ Auto queue worker completed');
                    break;
                }

                // Small delay between iterations to prevent resource overload
                sleep(5);
            } catch (\Exception $e) {
                Log::error('Queue worker error: ' . $e->getMessage());
                $this->error('Queue worker error: ' . $e->getMessage());

                // Don't exit on error, just log it and continue
                sleep(10);
            }
        }

        return 0;
    }
}
