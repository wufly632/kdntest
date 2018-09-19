<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\Good;

use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\Good\GoodSkuImage;
use App\Repositories\Good\GoodRepository;
use App\Validators\Good\GoodValidator;

class GoodService{

    /**
     * @var GoodRepository
     */
    protected $repository;

    /**
     * @var GoodValidator
     */
    protected $validator;

    /**
     * GoodsController constructor.
     *
     * @param GoodRepository $repository
     * @param GoodValidator $validator
     */
    public function __construct(GoodRepository $repository, GoodValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function getList($request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->repository->orderBy($orderBy, $sort)->paginate($length);
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
            if ($good->status != AuditGood::WAIT_AUDIT) {
                return false;
            }
            $good->status = AuditGood::WAIT_EDIT;
            $good->save();
            // 同步商品数据
            $this->syncGoodData($good);
            DB::commit();
            return true;
        } catch (\Exception $e) {
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
        $online_good = Good::find($good->id);
        $data = $good->only(AuditGood::$syncField);
        if ($online_good) {
            Good::where('id', $good->id)->update($data);
        } else {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['status'] = Good::OFFLINE;
            Good::insert($data);
        }
    }

    /**
     * 同步goods表
     */
    private function syncGoodskus($good_id, $goodSkus)
    {
        $goodSkus = $goodSkus->map(function($item) {
            return $item->only(AuditGoodSku::$syncField);
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
            return $item->only(AuditGoodSkuImage::$syncField);
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
            return $item->only(AuditGoodAttrValue::$syncField);
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
        if ($good->status != AuditGood::WAIT_AUDIT) {
            return false;
        }
        $good->status = AuditGood::REJECT;
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
        $good->status = AuditGood::RETURN;
        if ($good->save()){
            return true;
        }
        return false;
    }

}