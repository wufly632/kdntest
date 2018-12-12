<?php

namespace App\Console\Commands\Order;

use App\Entities\Order\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateOrderCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:order_cancel {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '30分钟未支付自动取消用户订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('y'))
        {
            $this->handleProgress();
        }else{
            if ($this->confirm('Do you want to continue? [y|N]')) {
                $this->handleProgress();
            }
        }
    }

    public function handleProgress()
    {
        try {
            DB::beginTransaction();
            Order::where([
                ['created_at', '<=', Carbon::now()->subMinutes(30)],
                ['status', '=', Order::WAIT_PAY]
            ])->update(['status' => Order::CANCEL]);
            DB::commit();
        } catch (\Exception $e) {
            ding('自动取消订单失败:'-$e->getMessage());
            DB::rollBack();
        }
    }
}
