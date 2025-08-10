<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CleanupTempFiles;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Clean up temporary files daily at 2 AM
        $schedule->job(new CleanupTempFiles())
            ->daily()
            ->at('02:00')
            ->name('cleanup-temp-files')
            ->withoutOverlapping()
            ->onOneServer();

        // Clear expired cache entries
        $schedule->command('cache:prune-stale-tags')
            ->hourly()
            ->name('cache-cleanup')
            ->withoutOverlapping();

        // Clear view cache weekly
        $schedule->command('view:clear')
            ->weekly()
            ->sundays()
            ->at('03:00')
            ->name('view-cache-clear');

        // Restart queue workers to prevent memory leaks
        $schedule->command('queue:restart')
            ->daily()
            ->at('04:00')
            ->name('queue-restart')
            ->withoutOverlapping();

        // Generate sitemap daily at 1 AM
        $schedule->command('sitemap:generate')
            ->daily()
            ->at('01:00')
            ->name('sitemap-generate')
            ->withoutOverlapping()
            ->onOneServer();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
