<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\Good;

use App\Criteria\Good\GoodCodeCriteria;
use App\Criteria\Good\GoodIdCriteria;
use App\Criteria\Good\GoodTitleCriteria;
use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Good\Good;
use App\Entities\Good\GoodSku;
use App\Entities\Good\GoodSkuImage;
use App\Entities\Product\Product;
use App\Entities\Product\ProductAttrValue;
use App\Entities\Product\ProductSku;
use App\Repositories\Good\GoodRepository;
use App\Repositories\Product\ProductRepository;
use App\Validators\Good\GoodValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoodService{

    /**
     * @var GoodRepository
     */
    protected $good;

    /**
     * @var ProductRepository
     */
    protected $product;

    /**
     * @var GoodValidator
     */
    protected $validator;

    /**
     * GoodsController constructor.
     *
     * @param GoodRepository $good
     * @param GoodValidator $validator
     */
    public function __construct(GoodRepository $good, GoodValidator $validator,
                                ProductRepository $product)
    {
        $this->good = $good;
        $this->validator  = $validator;
        $this->product = $product;
    }

    public function getGoodModel()
    {
        return $this->good->makeModel();
    }

    public function getList($request)
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        $this->good->pushCriteria(new GoodTitleCriteria($request->good_title));
        $this->good->pushCriteria(new GoodIdCriteria($request->id));
        $this->good->pushCriteria(new GoodCodeCriteria($request->good_code));
        return $this->good->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * 获取产品sku图片
     * 并组装相关信息
     * 图片属性值id对应相关产品sku图片
     *
     * @param array $good_skus
     * @param int $category_id
     * @return mixed
     */
    public function getProductSkuImage($good_skus, int $category_id)
    {
        $image_arr = [];
        if(!$good_skus){
            return [];
        }
        $pic_attribute_value_ids_arr = $this->getPicAttributeValueIdsArr($category_id);
        foreach ($good_skus as $key => $value) {
            foreach ($value->skuAttributes as $k => $v) {
                $attributeValueIds = explode(',', $v->value_ids);
                foreach ($attributeValueIds as $attributeValueId) {
                    if(in_array($attributeValueId, $pic_attribute_value_ids_arr)){
                        $image_arr[$attributeValueId][] = GoodSkuImage::where(['sku_id' => $value->id])->get()->toArray();
                    }
                }
            }
        }
        foreach($image_arr as $key => $value){
            $image_arr[$key] = collect($value)->collapse()->unique();
        }
        return $image_arr;
    }

    /**
     * 获取该分类对应的图片分类属性
     *
     * @param int $category_id 分类id
     * @return mixed
     */
    public function getPicAttributeValueIdsArr(int $category_id)
    {
        $category_attributes = CategoryAttribute::where(['category_id' => $category_id, 'is_image' => 1, 'status' => 1])->get();
        $attr_value_ids = array_unique(explode(',', implode(',', array_pluck($category_attributes, 'attr_values'))));
        return $attr_value_ids;
    }

    /**
     * 审核通过
     */
    public function auditPass($request)
    {
        try {
            DB::beginTransaction();
            $good = $this->good->find($request->id);
            if ($good->status != Good::WAIT_AUDIT) {
                return false;
            }
            $good->status = Good::WAIT_EDIT;
            $good->save();
            // 同步商品数据
            $this->syncGoodData($good);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            debug($e->getMessage());
            DB::rollback();
            return false;
        }
    }

    /**
     * 同步商品数据到正式表
     */
    public function syncGoodData($good)
    {
        // 同步goods表
        $this->syncProducts($good);
        // 同步good_skus表
        $this->syncGoodskus($good->id,$good->getSkus);
        // 同步good_sku_images表
        $this->syncGoodSkuImages($good->id,$good->getImages);
        // 同步goods_attr_value表
        $this->syncGoodAttrValue($good->id,$good->getAttrValue);
    }

    /**
     * 同步goods表
     */
    private function syncProducts($good)
    {
        $data = $good->only(Good::$syncField);

            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['status'] = Product::OFFLINE;
            $this->product->create($data);
    }

    /**
     * 同步goods表
     */
    private function syncGoodskus($good_id, $goodSkus)
    {
        $goodSkus = $goodSkus->map(function($item) {
            return $item->only(GoodSku::$syncField);
        })->toArray();
        GoodSku::where('good_id', $good_id)->delete();
        GoodSku::insert($goodSkus);
    }

    /**
     * 同步good_sku_images表
     */
    private function syncGoodSkuImages($good_id, $goodSkuimages)
    {
        $goodSkuimages = $goodSkuimages->map(function ($item) {
            return $item->only(GoodSkuImage::$syncField);
        })->toArray();
        GoodSkuImage::where('good_id', $good_id)->delete();
        GoodSkuImage::insert($goodSkuimages);
    }

    /**
     * 同步good_sku_images表
     */
    private function syncGoodAttrValue($good_id, $goodAttrValues)
    {
        $goodAttrValues = $goodAttrValues->map(function ($item){
            return $item->only(GoodAttrValue::$syncField);
        })->toArray();
        GoodAttrValue::where('good_id', $good_id)->delete();
        GoodAttrValue::insert($goodAttrValues);
    }

    /**
     * 审核拒绝
     */
    public function auditReject($request)
    {
        $good = $this->good->find($request->id);
        if ($good->status != Good::WAIT_AUDIT) {
            return false;
        }
        $good->status = Good::REJECT;
        if ($good->save()){
            return true;
        }
        return false;
    }

    /**
     * 退回修改
     */
    public function auditReturn($request)
    {
        $good = $this->good->find($request->id);
        $good->status = Good::RETURN;
        if ($good->save()){
            return true;
        }
        return false;
    }

    /**
     * @function 商品编辑
     * @param $request
     * @return bool
     */
    public function editPost($request)
    {
        try {
            DB::beginTransaction();
            $this->product->update(['good_en_title' => $request->good_en_title], $request->id);
            $this->good->update(['status' => Good::EDITED], $request->id);
            //修改自定义属性
            foreach ($request->attr_id as $attr_id => $en_value) {
                GoodAttrValue::where(['good_id' => $request->id, 'attr_id' => $attr_id])->update(['value_name' => $en_value]);
                ProductAttrValue::where(['good_id' => $request->id, 'attr_id' => $attr_id])->update(['value_name' => $en_value]);
            }
            //修改sku价格
            foreach ($request->good_sku['price'] as $sku_id => $price) {
                ProductSku::where(['id' => $sku_id])->update(['price' => $price]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }
    }

}