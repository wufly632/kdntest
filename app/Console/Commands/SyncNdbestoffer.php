<?php

namespace App\Console\Commands;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Good\Good;
use App\Entities\Good\GoodSku;
use App\Entities\Good\GoodSkuImage;
use App\Entities\Supplier\SupplierUser;
use App\Services\CateAttr\CategoryService;
use App\Traits\HttpRequestTrait;
use Illuminate\Console\Command;

class SyncNdbestoffer extends Command
{

    use HttpRequestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ndbestoffer {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync ndbestoffer website product';


    const RELATIONS = [
        '手机壳' => '手机保护套',
        '手机膜' => '手机保护膜',
        '耳机' => '耳机',
        '音箱' => '音箱',
        '移动电源' => '移动电源',
        '车载产品' => '手机车载配件',
        '充电器' => '手机充电器',
        '数据线' => '手机数据线',
        '转换器' => '其他手机配件',
        '读卡器' => '其他手机配件',
        '手表' => '智能手表',
        '其他' => '其他手机配件'
    ];

    protected $categoryService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        //
        if ($this->option('y')) {
            $this->handleProgress();
        } else {
            if ($this->confirm('Do you want to continue? [y|N]')) {
                $this->handleProgress();
            }
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function handleProgress()
    {
//        $uri = 'http://219.135.103.230:8088/external_interface/syn_api.html';
//        $params = [
//            'interface_type' => 'prod_cat_data_syn_api',
//            'mch_id' => '9082AE35AD861D8327F053CEDD53B1A1',
//        ];
//        $res = $this->makePostRequest($uri, $params)['result'];
//        dd($res);
        //
        \Cache::put('sync_ndbest_offer', time(), 43200);
        $this->syncData(1);
    }

    /**
     * 同步每页数据
     * @param $page
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function syncData($page)
    {
        $uri = 'http://219.135.103.230:8088/external_interface/syn_api.html';

        $params = [
            'interface_type' => 'prod_data_syn_api',
            'mch_id' => '9082AE35AD861D8327F053CEDD53B1A1',
            'synTimestamp' => '1000000000',
            'PrmPageNo' => $page
        ];
        $res = $this->makePostRequest($uri, $params);
        $this->createOrUpdateData($res['result']);
        if ($res['page']['pageNo'] >= $res['page']['totalPageCount']) {
            $this->info('sync success');
            return true;
        } else {
            $this->info('第' . $res['page']['pageNo'] . '页同步完毕');
            return $this->syncData(++$res['page']['pageNo']);
        }
    }

    /**
     * 写入数据
     * @param $res
     */
    protected function createOrUpdateData($res)
    {
        $supplierId = $this->getSupplierId();
        foreach ($res as $item) {
            try {
                \DB::beginTransaction();
                if ($item['fullCategoryName'][0]['categoryName'] == '其他') {
                    $categoryName = self::RELATIONS[$item['fullCategoryName'][1]['categoryName']];
                } else {
                    $categoryName = self::RELATIONS[$item['fullCategoryName'][0]['categoryName']];
                }
                $cateInfo = $this->categoryService->getCateByName($categoryName);
                $mathes = [];
                preg_match_all('/src=\"(.*?)\"/', $item['fullDescription'], $mathes);
                $skus = $item['skus'];
                $goodInfo = Good::updateOrCreate(['good_code' => $item['productId'] . $item['productCode'], 'supplier_id' => $supplierId], [
                    'category_id' => $cateInfo['id'],
                    'category_path' => $cateInfo['category_ids'] . ',' . $cateInfo['id'],
                    'supply_price' => $this->getMinPrice($skus),
                    'good_stock' => $this->getSumStock($skus),
                    'good_title' => $item['productName'],
                    'good_en_title' => $item['productEnName'],
                    'main_pic' => $item['images'] ? $item['images'][0]['mediaUrl'] : '',
                    'content' => json_encode($mathes[1]),
                ]);
                if ($goodInfo->status == 0) {
                    $goodInfo->status = 1;
                    $goodInfo->save();
                }
                $attrIds = array_pluck(CategoryAttribute::where('category_id', $cateInfo['id'])->get()->toArray(), 'attr_id');
                foreach ($skus as $key => $sku) {
                    if ($sku['unit'] == 'g') {
                        $weight = $sku['weight'] / 1000;
                    } else {
                        $weight = $sku['weight'];
                    }
                    $goodSku = GoodSku::updateOrCreate([
                        'good_id' => $goodInfo->id,
                        'supplier_code' => $sku['productSkuCode']
                    ], [
                        'supply_price' => $sku['price'],
                        'good_stock' => $sku['inventory'],
                        'weight' => $weight,
                        'icon' => $sku['image']
                    ]);
                    GoodSkuImage::updateOrCreate([
                        'good_id' => $goodInfo->id,
                        'sku_id' => $goodSku->id,
                    ], [
                        'src' => $sku['image']
                    ]);
                    $valueIds = '';
                    $skuOptionValues = $sku['skuOptionValue'];
                    if ($skuOptionValues) {
                        foreach ($skuOptionValues as $skuOptionValue) {
                            $attribute = Attribute::where('name', '颜色')->whereIn('id', $attrIds)->first();
                            if ($skuOptionValue['skuOptionName'] == '颜色') {
                                $attributeValue = AttributeValue::where('attribute_id', $attribute->id)->where('name', $skuOptionValue['skuOptionValue'])->first();
                                if (!$attributeValue) {
                                    $attributeValue = AttributeValue::where('attribute_id', $attribute->id)->get()[$key];
                                }
                            } else {
                                $attributeValue = AttributeValue::where('attribute_id', $attribute->id)->get()[$key];
                            }

                            GoodAttrValue::updateOrCreate([
                                'good_id' => $goodInfo->id,
                                'sku_id' => $goodSku->id,
                                'attr_id' => $attribute->id,
                                'value_ids' => $attributeValue->id,
                                'value_name' => $skuOptionValue['skuOptionValue']
                            ]);

                            $valueIds .= $attributeValue->id . ',';
                        }
                        $valueIds = rtrim($valueIds, ',');
                    } else {
                        $attribute = Attribute::where('name', '颜色')->first();
                        $attributeValue = AttributeValue::where('name', '通用')->where('attribute_id', $attribute->id)->first();
                        GoodAttrValue::updateOrCreate([
                            'good_id' => $goodInfo->id,
                            'sku_id' => $goodSku->id,
                            'attr_id' => $attribute->id,
                            'value_ids' => $attributeValue->id,
                            'value_name' => '通用'
                        ]);
                        $valueIds = $attributeValue->id;
                    }
                    $goodSku->value_ids = $valueIds;
                    $goodSku->save();
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
            }
        }
    }

    protected function getSupplierId()
    {
        $supplier = SupplierUser::firstOrCreate(['name' => 'ndbestoffer']);
        if (!$supplier->email) {
            $supplier->email = 'ndbestoffer';
        }
        if (!$supplier->password) {
            $supplier->password = \Hash::make('Ww123456');
        }
        $supplier->save();
        return $supplier->id;
    }

    public function getMinPrice($skus)
    {
        $priceArr = [];
        foreach ($skus as $sku) {
            array_push($priceArr, $sku['price']);
        }
        return min($priceArr);
    }

    public function getSumStock($skus)
    {
        $stock = [];
        foreach ($skus as $sku) {
            array_push($stock, $sku['inventory']);
        }
        return array_sum($stock);
    }
}
