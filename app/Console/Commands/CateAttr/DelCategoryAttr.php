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

class DelCategoryAttr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:category_attribute {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除类目的非销售属性';

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
            265 => [279]
        ];

        foreach ($cate_attrs as $attr_id => $category_ids)
        {
            $attr_values = AttributeValue::where('attribute_id', $attr_id)->pluck('id')->toArray();
            // 删除该类目属性
            CategoryAttribute::where(['attr_id' => $attr_id])
                ->whereIn('category_id', $category_ids)
                ->delete();
            // 查找所有商品
            $category_goods = Good::whereIn('category_id', $category_ids)->pluck('id')->toArray();
            // 查找所有audit_goods_attr_value
            GoodAttrValue::where('attr_id', $attr_id)->whereIn('good_id', $category_goods)->delete();
            ProductAttrValue::where('attr_id', $attr_id)->whereIn('good_id', $category_goods)->delete();
            $this->info('finish!');
        }
    }
}
