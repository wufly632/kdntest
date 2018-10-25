<?php

namespace App\Console\Commands\PushOrder;

use App\Entities\Product\ProductSku;
use App\Entities\PushOrder\PushOrder;
use App\Entities\PushOrder\Requirement;
use App\Entities\PushOrder\Surplus;
use App\Entities\PushOrder\SurplusRecord;
use App\Entities\ShipOrder\PreShipOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Log;

class GenerateSupplierOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:push_orders {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时给商家推送订单';

    protected $batchId;

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
        ding('调用了推单脚本');
        $time = Carbon::now()->minute(0)->second(0);
        $this->batchId = $time->format('YmdH');
        $time = $time->toDateTimeString();
        // 获取所有未推送的需求数据
        $obj = Requirement::where([['is_push', '=', 0],['created_at', '<', $time]])
            ->selectRaw('sum(num) as number,sku_id')
            ->groupBy('sku_id');
        $this->output->progressStart($obj->count());
        $obj->chunk(100, function($data) use ($time){
                foreach ($data as $item)
                {
                    try {
                        DB::beginTransaction();
                        $surplus = Surplus::firstOrNew(['sku_id' => $item->sku_id]);
                        if ($item->number < 0) {
                            //需求量小于0 -> 全部转入结余
                            $surplus->num -= $item->number;
                            $surplus->save();
                            SurplusRecord::create([
                                'sku_id' => $item->sku_id,
                                'num'    => -$item->number,
                                'final_num' => $surplus->num,
                                'note'   => '需求结转',
                                'batch_id' => $this->batchId,
                                'created_at' => Carbon::now()->toDateTimeString(),
                            ]);
                        } elseif ($item->number > 0) {
                            // 判断结余量是否充足
                            if ($surplus->num > 0) {
                                if ($item->number > $surplus->num) {
                                    // 需求量大于结余量(结余量清零，推需求量-结余量)
                                    $surplus->num = 0;
                                    $changeNum = $surplus->num;
                                    $surplus->save();
                                    SurplusRecord::create([
                                        'sku_id' => $item->sku_id,
                                        'num'    => -$changeNum,
                                        'final_num' => 0,
                                        'note'   => '结转清零',
                                        'batch_id' => $this->batchId,
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                    ]);

                                    $this->pushOrder($item->sku_id, $item->number-$changeNum);
                                } else {
                                    // 不推单，结余量减少(需求量)
                                    $surplus->num += $item->number;
                                    $surplus->save();
                                    SurplusRecord::create([
                                        'sku_id' => $item->sku_id,
                                        'num'    => $item->number,
                                        'final_num' => $surplus->num,
                                        'note'   => '需求结转',
                                        'batch_id' => $this->batchId,
                                        'created_at' => Carbon::now()->toDateTimeString(),
                                    ]);
                                }
                            } else {
                                // 推单 需求量
                                $this->info($item->sku_id.'-'.$item->number);
                                $this->pushOrder($item->sku_id, $item->number);
                            }
                        }
                        //
                        Requirement::where([['sku_id', '=', $item->sku_id], ['is_push', '=', 0], ['created_at', '<', $time]])
                            ->update(['is_push' => 1]);
                        DB::commit();
                        $this->output->progressAdvance();
                    } catch (\Exception $e) {
                        Log::info('推单('.$this->batchId.')失败：'.$e->getMessage());
                        ding('推单('.$this->batchId.')失败：'.$e->getMessage());
                        DB::rollBack();
                        $this->output->progressAdvance();
                    }
                }
            });
        ding('推单finish');
        $this->output->progressFinish();
        $this->comment('Finished!');
    }

    private function pushOrder($sku_id,$num)
    {
        // 生成待发货sku
        $sku = ProductSku::where(['id' => $sku_id])->first();
        $pre_ship_order = PreShipOrder::create([
           'sku_id' => $sku->id,
           'good_id' => $sku->good_id,
           'supplier_id' => $sku->getProduct->supplier_id,
           'num' => $num,
           'confirmed_num' => 0,
           'accepted_num' => 0,
           'supply_price' => $sku->supply_price,
           'status' => PreShipOrder::WAIT_CREATE,
           'created_at' => Carbon::now()->toDateTimeString(),
        ]);
        //生成推单表
        $push_order = PushOrder::create([
            'sku_id' => $sku->id,
            'batch_id' => $this->batchId,
            'good_id' => $sku->good_id,
            'supplier_id' => $sku->getProduct->supplier_id,
            'num' => $num,
            'accepted' => 0,
            'need_num' => $num,
            'supply_price' => $sku->supply_price,
            'status' => 1,//未满足
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
