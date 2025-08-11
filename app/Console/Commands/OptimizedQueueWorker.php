<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class OptimizedQueueWorker extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'queue:work-optimized
                            {--queue=emails : The queue to process}
                            {--tries=3 : Number of attempts per job}
                            {--timeout=300 : Timeout for each job in seconds}
                            {--memory=512 : Memory limit in MB}
                            {--sleep=5 : Sleep when no jobs available (anti-spam)}
                            {--max-jobs=50 : Max jobs before worker restart}
                            {--max-time=1800 : Max time before worker restart (30 min)}';

    /**
     * The console command description.
     */
    protected $description = 'Run queue worker with optimized settings for email and PDF processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $queue = $this->option('queue');
        $tries = $this->option('tries');
        $timeout = $this->option('timeout');
        $memory = $this->option('memory');
        $sleep = $this->option('sleep');
        $maxJobs = $this->option('max-jobs');
        $maxTime = $this->option('max-time');

        $this->info("🚀 Starting optimized queue worker for email processing");
        $this->info("📧 Queue: {$queue}");
        $this->info("⚙️  Settings: tries={$tries}, timeout={$timeout}s, memory={$memory}MB");
        $this->info("🛡️  Anti-spam: sleep={$sleep}s, max-jobs={$maxJobs}, max-time={$maxTime}s");

        // Set memory limit for PHP
        ini_set('memory_limit', $memory . 'M');

        // Set email-specific timeouts
        ini_set('default_socket_timeout', 60);
        ini_set('max_execution_time', $timeout);

        // Run the queue worker with anti-spam and reliability settings
        Artisan::call('queue:work', [
            '--queue' => $queue,
            '--tries' => $tries,
            '--timeout' => $timeout,
            '--memory' => $memory,
            '--sleep' => $sleep,
            '--max-jobs' => $maxJobs, // Prevent memory leaks
            '--max-time' => $maxTime, // Regular restarts for stability
        ]);

        $this->info("✅ Queue worker completed successfully");
        return 0;
    }
}
