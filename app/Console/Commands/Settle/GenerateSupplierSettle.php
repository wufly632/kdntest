<?php

namespace App\Console\Commands\Settle;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;

class GenerateSupplierSettle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:supplier_settle {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每月定时生成商家结算单';

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
        $start_time = Carbon::today()->subMonth()->toDateTimeString();
        $end_time = Carbon::today()->addDay()->toDateTimeString();
        // 生成结算单
        DB::table('ship_order_receive_daily')
            ->selectRaw('supplier_id,sum(num*supply_price) as amount,sum(commision) as commision')
            ->whereBetween('created_at', [$start_time, $end_time])
            ->groupBy('supplier_id')
            ->orderBy('supplier_id', 'asc')
            ->chunk(100, function ($items) use ($start_time,$end_time){
                foreach ($items as $item) {
                    try {
                        DB::beginTransaction();
                        $settle_data = [
                            'settle_code' => $this->makeSettleCode($item->supplier_id),
                            'supplier_id' => $item->supplier_id,
                            'amount' => $item->amount,
                            'commision' => $item->commision,
                            'status'  => 1,
                            'created_at' => Carbon::now()->toDateTimeString()
                        ];
                        $settle_id = DB::table('supplier_settle_accounts')->insertGetId($settle_data);
                        $receive_daily_ids = DB::table('ship_order_receive_daily')
                            ->where('supplier_id', $item->supplier_id)
                            ->whereBetween('created_at', [$start_time, $end_time])
                            ->pluck('id');
                        $settle_receive_data = [];
                        foreach ($receive_daily_ids as $receive_daily_id) {
                            $tmp['receive_daily_id'] = $receive_daily_id;
                            $tmp['settle_id'] = $settle_id;
                            $tmp['created_at'] = Carbon::now()->toDateTimeString();
                            $settle_receive_data[] = $tmp;
                        }
                        DB::table('supplier_settle_receive')->insert($settle_receive_data);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        \Log::info($item->supplier_id.'生成结算单出错-'.$e->getMessage());
                        ding($item->supplier_id.'生成结算单出错-'.$e->getMessage());
                        continue;
                    }
                }
            });
        ding(date('Y-m-d').' 生成结算单完成!');
    }

    /**
     * @function 生成结算单号
     * @param $supplier_id
     * @return string
     */
    private function makeSettleCode($supplier_id)
    {
        $date = date('ymdHis');
        $code = 'TX'.$date.rand(10,99).sprintf("%04d", $supplier_id).rand(10,99);
        return $code;
    }
}
