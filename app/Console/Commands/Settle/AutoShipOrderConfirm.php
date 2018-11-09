<?php

namespace App\Console\Commands\Settle;

use App\Entities\PushOrder\PushOrder;
use App\Entities\ShipOrder\PreShipOrder;
use App\Entities\ShipOrder\ShipOrder;
use App\Entities\ShipOrder\ShipOrderItem;
use App\Services\Good\GoodService;
use App\Services\Product\ProductService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoShipOrderConfirm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:ship_order_confirm {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发货单到货自动确认';

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
        // 部分到货/全部到货超过两天自动确认
        $start_time = Carbon::today()->subDay(3)->toDateTimeString();
        $end_time = Carbon::today()->subDay(2)->toDateTimeString();
        $ship_order_ids = ShipOrder::whereIn('status', [ShipOrder::PARTLYINHOUSED, ShipOrder::ACCEPTANCE])
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('partlyinhouse_at', [$start_time, $end_time])
                    ->orWhereBetween('acceptance_at', [$start_time, $end_time]);
            })->pluck('id');
        //更新发货单状态
        ShipOrder::whereIn('id', $ship_order_ids)->update(['status' => ShipOrder::CLOSED]);
        $ship_order_items = ShipOrderItem::whereIn('ship_order_id', $ship_order_ids)->get();
        $preShipOrderData = [];
        foreach ($ship_order_items as $ship_order_item) {
            if ($ship_order_item->num != $ship_order_item->accepted) {
                    $supplier_id = ShipOrder::find($ship_order_item->ship_order_id)->supplier_id;
                    $tmp['supplier_id'] = $supplier_id;
                    $tmp['num'] = $ship_order_item->num - $ship_order_item->accepted;
                    $tmp['sku_id'] = $ship_order_item->sku_id;
                    $tmp['good_id'] = $ship_order_item->good_id;
                    $tmp['supply_price'] = $ship_order_item->supply_price;
                    $tmp['status'] = PreShipOrder::WAIT_CREATE;
                    $tmp['created_at'] = Carbon::now()->toDateTimeString();
                    $preShipOrderData[] = $tmp;
            }
        }
        PreShipOrder::insert($preShipOrderData);
        // 生成到货满足记录
        foreach ($ship_order_items as $shipOrderItem) {
            $itemLeft = $shipOrderItem->accepted;
            if ($itemLeft) {
                $this->matchItemWithPush($itemLeft, $shipOrderItem->sku_id);
            }
        }
        ding(date('Y-m-d').'自动确认收货完成');

    }

    public function matchItemWithPush($itemLeft, $sku_id)
    {
        $matchPushOrder = PushOrder::where([['sku_id', '=', $sku_id],['status', '=', 1]])->first();
        if (!$matchPushOrder || $needLeft = $matchPushOrder->need_num <= 0) {
            ding('SKU ID-'.$sku_id.'收货无法匹配');
            return;
        }
        if ($needLeft >= $itemLeft) {
            if ($needLeft = $itemLeft) {
                PushOrder::where('id', $matchPushOrder->id)->update(['accepted' => $matchPushOrder->num, 'status' => 2, 'need_num' => 0]);
            } else {
                PushOrder::where('id', $matchPushOrder->id)->increment('accepted', $itemLeft);
            }
            $fillData = [
                'push_order_id' => $matchPushOrder->id,
                'num' => $itemLeft,
                'created_at' => Carbon::now()->toDateTimeString()
            ];
            DB::table('push_order_fills')->insert($fillData);
            return;
        } else {
            PushOrder::where('id', $matchPushOrder->id)->update(['accepted' => $matchPushOrder->num, 'status' => 2, 'need_num' => 0]);
            $fillData = [
                'push_order_id' => $matchPushOrder->id,
                'num' => $needLeft,
                'created_at' => Carbon::now()->toDateTimeString()
            ];
            DB::table('push_order_fills')->insert($fillData);
            $itemLeft -= $needLeft;
            $this->matchItemWithPush($itemLeft, $sku_id);
        }
    }

}
