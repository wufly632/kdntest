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

        //每日定时统计商品到货数量
        $schedule->command('generate:supplier_product_receive --y')->dailyAt('1:00');

        //每月定时生成结算单(1号凌晨12：30）
        $schedule->command('generate:supplier_settle --y')->monthlyOn(1, '0:30')->timezone('Asia/Shanghai');

        //发货单自动确认
        $schedule->command('auto:ship_order_confirm --y')->dailyAt('0:10');
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
