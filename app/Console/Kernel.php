<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Program\Import::class,
        Program\Update::class,
        Audio\Download::class,
        Audio\Convert::class,
        Music\Import::class,
        Music\Copy::class,
        Music\Repair::class,
        Music\Deploy::class,
        Tool\UpdateBingCover::class,
        Tool\SyncAppProgram::class,
        Comment\Sync::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }
}
