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
                            {--sleep=3 : Sleep when no jobs available}';

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

        $this->info("Starting optimized queue worker for queue: {$queue}");
        $this->info("Settings: tries={$tries}, timeout={$timeout}s, memory={$memory}MB, sleep={$sleep}s");

        // Set memory limit
        ini_set('memory_limit', $memory . 'M');

        // Run the queue worker with optimized parameters
        Artisan::call('queue:work', [
            '--queue' => $queue,
            '--tries' => $tries,
            '--timeout' => $timeout,
            '--memory' => $memory,
            '--sleep' => $sleep,
            '--max-jobs' => 100, // Restart worker after 100 jobs to prevent memory leaks
            '--max-time' => 3600, // Restart worker after 1 hour
        ]);

        return 0;
    }
}
