<?php

namespace App\Console;

use Illuminate\Console\Command;
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
        Commands\SyncCategory::class,
        Commands\SyncAttributeValue::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('generate:push_orders --y')->cron('0 0-24/2 * * * *');
        // $schedule->command('generate:push_orders --y')->everyMinute();

        //订单30分钟未支付自动取消
        $schedule->command('generate:order_cancel --y')->everyMinute();

        //每天凌晨2点自动备份数据库
        $schedule->command('backup:clean')->dailyAt('2:00');
        $schedule->command('backup:run --only-db')->dailyAt('3:00');
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
