<?php
// +----------------------------------------------------------------------
// | FixProductOriginPrice.php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Time: 2018/11/13 下午8:13
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Console\Commands\Product;

use App\Entities\Good\Good;
use App\Entities\Product\Product;
use Illuminate\Console\Command;

class FixProductOriginPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:product_origin_price {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修复商品的原价与sku原价不一致';

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
        $products = Product::all();
        foreach ($products as $product) {
            $origin_price = $product->productSku()->min('origin_price');
            if ($origin_price != $product->origin_price)
            {
                $product->origin_price = $origin_price;
                $product->save();
            }
        }
        $this->info('end!');
    }
}
