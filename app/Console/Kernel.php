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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // Celsius tends to update rates on Fridays or Mondays, so we check more frequently on those days
        $schedule->command('getCelsiusRates')
                 ->everySixHours()
                 ->days([Schedule::TUESDAY,
                         Schedule::WEDNESDAY,
                         Schedule::THURSDAY,
                         Schedule::SATURDAY,
                         Schedule::SUNDAY]);

        $schedule->command('getCelsiusRates')
                 ->everyTwoHours()
                 ->days([Schedule::MONDAY,
                         Schedule::FRIDAY]);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
