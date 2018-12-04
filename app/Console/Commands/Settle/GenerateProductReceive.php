<?php

namespace App\Console\Commands\Settle;

use App\Entities\ShipOrder\ShipOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateProductReceive extends Command
{
    protected $sku_num = 0;
    protected $total_num = 0;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:supplier_product_receive {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计商家sku每日到货数量';

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

    private function handleProgress()
    {
        $date = Carbon::now()->subDay()->toDateString();
        // 查找今日所有到货sku
        DB::table('ship_orders as so')
            ->leftJoin('ship_order_items as soi', 'soi.ship_order_id', '=', 'so.id')
            ->selectRaw('soi.sku_id,soi.good_id,sum(soi.accepted) as num,so.supplier_id,soi.supply_price')
            ->whereRaw('to_days(so.closed_at) = to_days(now())')
            ->groupBy('soi.sku_id')
            ->orderBy('so.closed_at','asc')
            ->chunk(100, function ($sku_items) use ($date) {
                $data = [];
                foreach ($sku_items as $item) {
                    $tmp['good_id'] = $item->good_id;
                    $tmp['sku_id'] = $item->sku_id;
                    $tmp['num'] = $item->num;
                    $tmp['supplier_id'] = $item->supplier_id;
                    $tmp['supply_price'] = $item->supply_price;
                    $tmp['created_at'] = Carbon::now()->toDateTimeString();
                    $data[] = $tmp;
                    $this->sku_num ++;
                    $this->total_num += $item->num;
                }
                DB::table('ship_order_receive_daily')->insert($data);
            });
        ding('今日'.$date.' sku到货数-'.$this->sku_num.',总数-'.$this->total_num);
    }
}
