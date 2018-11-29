<?php

namespace App\Console\Commands\Product;

use App\Entities\Good\Good;
use App\Entities\Good\GoodSku;
use App\Entities\Product\Product;
use App\Entities\Product\ProductSku;
use Illuminate\Console\Command;
use DB;

class ChangeProductPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:product_price {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量修改商品的售价';

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
        $category_path = '0,1019,1063,%';
        //查找该类目下所有的商品
        $goods = Product::where('category_path', 'like', $category_path)
            ->get();
        foreach ($goods as $good) {
            //查找所有的sku
            $skus = ProductSku::where('good_id', $good->id)->get();
            foreach ($skus as $sku) {
                $sku->origin_price = $sku->price*1.6;
                $sku->save();
            }
            $good->origin_price = $good->price*1.6;
            $good->save();
            $this->info($good->id.'finish');
        }
        $this->info('finish!');




        /*$category_ids = [1,172,798,508];
        $this->info('start...');
        foreach ($category_ids as $category_id)
        {
            //查找该类目下所有的商品
            $goods = Good::where('category_path', 'like', '0,'.$category_id.',%')
                ->where('status', 4)
                ->get();
            foreach($goods as $good) {
                $change = false;
                //查找所有的sku
                $skus = GoodSku::where('good_id', $good->id)->get();
                foreach ($skus as $sku) {
                    // 判断售价 = 供货价*3/6.95
                    if ($sku->price < $sku->supply_price*3/6.95) {
                        $change = true;
                        $price = round($sku->supply_price*3/6.95*2,0)/2;
                        $origin_price = $price*1.3;
                        $sku->price = $price;
                        // $sku->origin_price = $origin_price;
                        $sku->save();
                        $sku_id = $sku->id;
                        ProductSku::where('id', $sku_id)->update(['origin_price' => $origin_price, 'price' => $price]);
                    }
                }
                if ($change) {
                    $good_price = $skus->min('price');
                    // $good_origin_price = $sku->min('origin_price');
                    // $good->origin_price = $good_origin_price;
                    $good->price = $good_price;
                    $good->save();
                    $origin_price = ProductSku::where('good_id', $good->id)->min('origin_price');
                    Product::where('id', $good->id)->update(['origin_price' => $origin_price, 'price' => $good_price]);
                }
                $this->info($good->id.'finished');
            }
        }
        $this->info('end...');*/
    }
}
