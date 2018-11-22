<?php

namespace App\Console\Commands\CateAttr;

use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Good\Good;
use App\Entities\Good\GoodSku;
use App\Entities\Product\Product;
use App\Entities\Product\ProductAttrValue;
use App\Entities\Product\ProductSku;
use Illuminate\Console\Command;

class DelSaleAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:sale_attribute {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除类目的销售属性';

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
        $cate_attrs = [
            985 => [1392,1393,1394,1395]
        ];

        foreach ($cate_attrs as $attr_id => $category_ids)
        {
            $attr_values = AttributeValue::where('attribute_id', $attr_id)->pluck('id')->toArray();
            // 删除该类目属性
            CategoryAttribute::where(['attr_id' => $attr_id, 'attr_type' => 3])
                ->whereIn('category_id', $category_ids)
                ->delete();
            // 查找所有商品
            $category_goods = Good::whereIn('category_id', $category_ids)->pluck('id')->toArray();
            // 获取所有的sku
            $category_good_skus = GoodSku::whereIn('good_id', $category_goods)->get();
            foreach ($category_good_skus as $category_good_sku)
            {
                $sku_attr_ids = explode(',', $category_good_sku->value_ids);
                foreach ($sku_attr_ids as $key => &$sku_attr_id)
                {
                    if (isset($attr_values[$sku_attr_id])) {
                        // sku表删除这个属性值
                        unset($sku_attr_ids[$key]);
                    }
                }
                $category_good_sku->value_ids = implode(',', $sku_attr_ids);
                $category_good_sku->save();
                // 删除商品属性表
                GoodAttrValue::where(['sku_id' => $category_good_sku->id, 'attr_id' => $attr_id])->delete();
                $this->info($category_good_sku->good_id.'-'.$category_good_sku->id.'-删除成功');
            }
            $this->info('审核表删除成功');
            // 查找所有商品
            $category_goods = Product::whereIn('category_id', $category_ids)->pluck('id')->toArray();
            // 获取所有的sku
            $category_good_skus = ProductSku::whereIn('good_id', $category_goods)->get();
            foreach ($category_good_skus as $category_good_sku)
            {
                $sku_attr_ids = explode(',', $category_good_sku->value_ids);
                foreach ($sku_attr_ids as $key => &$sku_attr_id)
                {
                    if (isset($attr_values[$sku_attr_id])) {
                        // sku表删除这个属性值
                        unset($sku_attr_ids[$key]);
                    }
                }
                $category_good_sku->value_ids = implode(',', $sku_attr_ids);
                $category_good_sku->save();
                // 删除商品属性表
                ProductAttrValue::where(['sku_id' => $category_good_sku->id, 'attr_id' => $attr_id])->delete();
                $this->info($category_good_sku->good_id.'-'.$category_good_sku->id.'-删除成功');
            }
            $this->info('finish!');
        }
    }
}
