<?php

namespace App\Console\Commands\Product;

use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Good\Good;
use App\Entities\Good\GoodSku;
use App\Entities\Product\Product;
use App\Entities\Product\ProductAttrValue;
use App\Entities\Product\ProductSku;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixProductSku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:change_product_sku {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修改商品sku的颜色值';

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
        // 增加色号
        $attribute_values = [
            '01#',
            '02#',
            '03#',
            '04#',
            '05#',
            '06#',
            '07#',
            '08#',
            '09#',
            '10#',
            '11#',
            '12#',
            '13#',
            '14#',
            '15#',
            '16#',
            '17#',
            '18#',
            '19#',
            '20#',
            '21#',
            '22#',
            '23#',
            '24#',
            '25#',
            '26#',
            '27#',
            '28#',
            '29#',
            '30#'
        ];
        $attributeIds = [];
        foreach ($attribute_values as $attribute_value)
        {
            $data = [
                'attribute_id' => 6,
                'name' => $attribute_value,
                'en_name' => $attribute_value,
                'value' => '',
                'sort' => 99,
                'created_at' => Carbon::now()->toDateTimeString()
            ];
            $attributeIds[] = AttributeValue::insertGetId($data);
        }

        $category_ids = [1024,1025,1026,1046];
        $product_ids = [101075,101074,101073,101072];
        // 查找该类目下所有商品
        $audit_goods = Good::whereIn('category_id', $category_ids)->pluck('id')->toArray();
        $audit_goods = array_merge($audit_goods, $product_ids);
        $goods = Product::whereIn('category_id', $category_ids)->pluck('id')->toArray();
        $goods = array_merge($goods, $product_ids);

        // 改变sku的属性
        foreach ($audit_goods as $audit_good) {
            // 改变audit_goods_attr_value
            $audit_goods_attr_values = GoodAttrValue::where('good_id', $audit_good)->where('sku_id','>', 0)->get();
            $i = 0;
            foreach ($audit_goods_attr_values as $audit_goods_attr_value) {
                if ($audit_goods_attr_value->attr_id == 6) {
                    // 替换属性值
                    $audit_goods_attr_value->value_ids = $attributeIds[$i];
                    $audit_goods_attr_value->value_name = $attribute_values[$i];
                    $audit_goods_attr_value->save();
                    ProductAttrValue::where(['good_id' => $audit_good, 'sku_id' => $audit_goods_attr_value->sku_id, 'attr_id' => 6])->update(['value_ids' => $attributeIds[$i],'value_name' => $attribute_values[$i]]);
                    //改变sku值
                    $value_ids = GoodAttrValue::where('good_id',$audit_good)->where('sku_id', $audit_goods_attr_value->sku_id)->pluck('value_ids')->implode(',');
                    GoodSku::where('id', $audit_goods_attr_value->sku_id)->update(['value_ids' => $value_ids]);
                    ProductSku::where('id', $audit_goods_attr_value->sku_id)->update(['value_ids' => $value_ids]);
                    $this->info($audit_good.'-'.$audit_goods_attr_value->sku_id.'修改完成');
                    $i++;
                }
            }
        }
        $this->info('finished');
    }
}
