<?php

namespace App\Console\Commands\CateAttr;

use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Good\Good;
use App\Entities\Good\GoodSku;
use App\Entities\Good\GoodSkuImage;
use App\Entities\Product\Product;
use App\Entities\Product\ProductAttrValue;
use App\Entities\Product\ProductSku;
use App\Entities\Product\ProductSkuImages;
use Illuminate\Console\Command;

class DelCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'del:category {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除类目及商品';

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
        $category_ids = [491];
        // 查找所有的商品
        $goods = Good::whereIn('category_id', $category_ids)->get();
        foreach ($goods as $good) {
            // 删除sku
            GoodSku::where('good_id', $good->id)->delete();
            // 删除图片
            GoodSkuImage::where('good_id', $good->id)->delete();
            // 删除属性
            GoodAttrValue::where('good_id', $good->id)->delete();

            $good->delete();
        }

        // 查找所有的商品
        $products = Product::whereIn('category_id', $category_ids)->get();
        foreach ($products as $product) {
            // 删除sku
            ProductSku::where('good_id', $good->id)->delete();
            // 删除图片
            ProductSkuImages::where('good_id', $good->id)->delete();
            // 删除属性
            ProductAttrValue::where('good_id', $good->id)->delete();

            $product->delete();
        }
        // 删除类目
        Category::whereIn('id', $category_ids)->delete();
        $this->info('end');
    }
}
