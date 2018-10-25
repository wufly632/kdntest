<?php
// +----------------------------------------------------------------------
// | PromotionService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/9/20 上午11:24
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Promotion;

use App\Criteria\Product\ProductCodeCriteria;
use App\Criteria\Product\ProductIdCriteria;
use App\Criteria\Product\ProductNotIdCriteria;
use App\Criteria\Product\ProductStatusCriteria;
use App\Criteria\Product\ProductTitleCriteria;
use App\Criteria\Promotion\PromotionCreateTimeCriteria;
use App\Criteria\Promotion\PromotionNameCriteria;
use App\Criteria\Promotion\PromotionStatusCriteria;
use App\Entities\Coupon\Coupon;
use App\Entities\Product\Product;
use App\Entities\Product\ProductSku;
use App\Entities\Promotion\PromotionGoodSku;
use App\Exceptions\CustomException;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Promotion\PromotionGoodRepository;
use App\Repositories\Promotion\PromotionGoodSkuRepository;
use App\Repositories\Promotion\PromotionRepository;
use App\Services\Api\ApiResponse;
use App\Validators\Promotion\PromotionGoodValidator;
use App\Validators\Promotion\PromotionValidator;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Request,Log;

class PromotionService
{
    /**
     * @var PromotionRepository
     */
    protected $promotion;

    /**
     * @var PromotionValidator
     */
    protected $promotionValidator;

    /**
     * @var PromotionGoodRepository
     */
    protected $promotionGood;

    /**
     * @var PromotionValidator
     */
    protected $promotionGoodValidator;

    /**
     * @var PromotionGoodSkuRepository
     */
    protected $promotionGoodSku;

    /**
     * @var ProductRepository
     */
    protected $product;

    /**
     * PromotionController constructor.
     *
     * @param PromotionRepository $good
     */
    public function __construct(
        PromotionRepository $promotion, PromotionValidator $promotionValidator,
        PromotionGoodRepository $promotionGood,
        PromotionGoodSkuRepository $promotionGoodSku,
        ProductRepository $product
    )
    {
        $this->promotion = $promotion;
        $this->promotionValidator = $promotionValidator;
        $this->promotionGood = $promotionGood;
        $this->promotionGoodSku = $promotionGoodSku;
        $this->product = $product;
    }

    /**
     * @function 获取促销活动列表
     */
    public function getList()
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        $this->promotion->pushCriteria(new PromotionCreateTimeCriteria(Request::input('create_time')));
        $this->promotion->pushCriteria(new PromotionNameCriteria(Request::input('title')));
        $this->promotion->pushCriteria(new PromotionStatusCriteria(Request::input('status')));
        return $this->promotion->orderBy($orderBy, $sort)->paginate($length);
    }

    /**
     * @function 活动预创建
     * @param $request
     * @return mixed
     */
    public function preCreate($request)
    {
        $time = get_time_range($request->promotion_time);
        // 判断是否有已存在的活动
        $result = $this->promotion->makeModel()
            ->where([['start_at', '<=', $time[0]],['end_at', '>=', $time[1]]])
            ->orWhere([['start_at', '<=', $time[1]], ['end_at', '>=', $time[1]]])
            ->first();
        if ($result) {
            return ApiResponse::failure(g_API_ERROR, '该时间段已有活动');
        }
        $data['title'] = $request->title;
        $data['start_at'] = $time[0];
        $data['end_at'] = $time[1];
        $data['user_id'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        if ($promotion = $this->promotion->create($data)) {
            return ApiResponse::success($promotion->id, '添加活动成功');
        }
        return ApiResponse::failure(g_API_ERROR, '添加活动失败');
    }

    /**
     * @function 添加促销活动
     * @param $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create($request)
    {
        try {
            $promotion = $this->transform($request);
            DB::beginTransaction();
            $this->promotion->update($promotion['promotion'], $request->id);
            foreach ($promotion['promotion_goods'] as $promotion_good) {
                $this->promotionGood->update($promotion_good, $promotion_good['id']);
            }
            if ($promotion['promotion_goods_sku']) {
                PromotionGoodSku::insert($promotion['promotion_goods_sku']);
            }
            DB::commit();
            return ApiResponse::success('保存成功');
        } catch (\Exception $e) {
            DB::rollback();
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    /**
     * @function 数据拼装
     * @param $request
     * @return mixed
     * @throws CustomException
     */
    private function transform($request)
    {
        $promotion['promotion'] = $request->only(['id','title','activity_type','is_all','pre_time','poster_pic','h5_poster_pic']);
        $promotion['promotion']['stock'] = 0;
        list($start_time,$end_time) = get_time_range($request->promotion_time);
        $promotion['promotion']['start_at'] = $start_time;
        $promotion['promotion']['end_at'] = $end_time;
        if ($request->pre_time) {
            $promotion['promotion']['pre_time'] = $request->pre_time;
            $start_time = Carbon::parse($start_time);
            $promotion['promotion']['show_at'] = $start_time->subDays($request->pre_time)->toDateTimeString();
        } else {
            $promotion['promotion']['show_at'] = $start_time;
        }

        $activity_goods = $this->promotionGood->findWhere(['activity_id' => $request->id]);
        if (! $activity_goods) {
            throw new CustomException('请添加要参加活动的商品');
        }
        // 获取活动类型
        $promotion_type_info = $this->getPromotionType($request);
        // 获取活动的商品信息
        $promotion_goods = $this->getPromotionGoods($request, $activity_goods);
        $sku_info = ProductSku::whereIn('good_id', $promotion_goods['good_ids'])->get();
        $promotion['promotion']['style'] = count($activity_goods);//活动-款式(商品总数)
        if ($request->activity_type == 'quantity') {
            // 货值（商品最高sku供货价*秒杀数量）
            $goodsValue = $activity_goods->map(function ($activity_good) {
               return $activity_good->num*$activity_good->getProduct->productSku->max('supply_price');
            })->sum();
        } else {
            // 货值（商品sku供货价*商品数量）
            $goodsValue = collect($sku_info)->map(function($sku) {
                return $sku->supply_price*$sku->good_stock;
            })->sum();
        }
        // 验证促销商品价格是否大于商品原价格
        foreach ($promotion_goods['promotion_goods_sku'] as $val) {
            foreach ($sku_info as $v) {
                if ($val['goods_id'] == $v->good_id && $val['sku_id'] == $v->value_ids) {
                    if($val['price'] > $v['supply_price']) {
                        throw new CustomException('促销价不能大于售价');
                        break;
                    }
                }
            }
        }
        $promotion['promotion']['goods_value'] = $goodsValue;
        $promotion['promotion'] = array_merge($promotion['promotion'], $promotion_type_info);
        $promotion = array_merge($promotion, $promotion_goods);
        return $promotion;
    }

    /**
     * @function 活动类型等信息
     * @param $request
     * @return array
     */
    private function getPromotionType($request)
    {
        $data = [
            'rule' => '',
            'rule_text' => '',
            'status' => '',
            'rule_type' => '',
            'consume' => ''
        ];
        switch($request->activity_type) {
            case 'reduce': //满减
                foreach($request->reduce_name as $key => $val){
                    if(empty(floatval($val)) || empty(floatval($request->reduce_value[$key]))) continue;
                    $tmp['money'] = $money = floatval($val);
                    $tmp['reduce'] = $reduce = floatval($request->reduce_value[$key]);
                    $rule[] = $tmp;
                    $rule_str[] = '消费满'.$val.'，减'.$request->reduce_value[$key];
                }
                $data['rule'] = json_encode($rule);
                $data['rule_text'] = implode('；', $rule_str);
                $data['status'] = 1;
                break;
            case 'return': //满返
                $data['consume'] = $consume = floatval($request->return_price);
                $data['rule_type'] = $request->return_name;
                // 查找返还的优惠券
                $price_sum = Coupon::whereIn('id', $request->return_ids)->sum('coupon_price');

                $data['rule'] = json_encode(['ids' => implode(',', $request->return_ids), 'value' => $price_sum]);
                $data['rule_text'] = '消费满'.$consume.'元，返价值'.$price_sum.'元现金券';
                $data['status'] = 1;
                break;
            case 'discount': //多件多折
                foreach($request->discount_name as $key => $val){
                    if(empty(intval($val)) || empty(floatval($request->discount_value[$key]))) continue;
                    $tmp['num'] = $num = intval($val);
                    $tmp['discount'] = $discount = floatval($request->discount_value[$key]);
                    $rule[] = $tmp;
                    $rule_str[] = '选购商品满'.$num.'件，享受'.$discount.'折优惠';
                }
                $data['rule'] = json_encode($rule);
                $data['rule_text'] = implode('；', $rule_str);
                $data['status'] = 1;
                break;
            case 'wholesale': // X元n件
                foreach($request->wholesale_name as $key => $val){
                    if(empty(intval($val)) || empty(floatval($request->wholesale_value[$key]))) continue;
                    $tmp['money'] = $money = intval($val);
                    $tmp['wholesale'] = $wholesale = floatval($request->wholesale_value[$key]);
                    $rule[] = $tmp;
                    $rule_str[] = $money.'元任选'.$wholesale.'件活动商品';
                }

                $data['rule'] = json_encode($rule);
                $data['rule_text'] = implode('；', $rule_str);
                $data['status'] = 1;
                break;
            case 'give': //买n免一
                $data['rule'] = $request->give_num;
                $data['rule_text'] = '买n免一';
                $data['status'] = 1;
                break;
            case 'limit': //限时特价
                $data['rule_type'] = $request->limit_type;
                $data['rule'] = $request->limit_num;
                $data['rule_text'] = '限时特价';
                break;
            case 'quantity': //限量秒杀
                $data['rule_type'] = $request->quantity_type;
                $data['rule'] = $request->quantity_price.$request->quantity_type;
                $data['num'] = $request->quantity_num;
                $data['rule_text'] = '限量秒杀';
                break;
            default:
                break;
        }
        return $data;
    }

    /**
     * @function 活动商品等信息
     * @param $request
     * @param $activity_goods
     * @return array
     * @throws CustomException
     */
    private function getPromotionGoods($request, $activity_goods)
    {
        $stock = 0;
        $pre_num = 0;
        // 商品信息
        $promotion_goods = [];
        // 商品sku信息
        $promotion_goods_sku = [];
        $good_ids = [];
        switch($request->activity_type){
            case 'limit':
            case 'quantity':
                foreach($activity_goods as $val) {
                    $good_id = $val->goods_id;
                    $good_ids[] = $good_id;
                    $good_tmp['id'] = $val->id;
                    $good_tmp['per_num'] = $request->input(['per_num'.$good_id]);
                    if ($request->input('num'.$good_id) !== null && ! $request->input('num'.$good_id)) {
                        throw new CustomException('请完善优惠活动的商品信息，商品id：'.$good_id);
                    }
                    /*if (! $request->input('num'.$good_id)) {
                        throw new CustomException('请完善优惠活动的商品信息，商品id：'.$good_id);
                    }*/
                    $good_tmp['num'] = $request->input('num'.$good_id);
                    $stock += $request->input('num'.$good_id);

                    $sku_tmp['activity_id'] = $request->id;
                    $sku_tmp['goods_id'] = $good_id;
                    if (empty($request->input('sku_id'.$good_id))) {
                        throw new CustomException('请重新添加商品，商品id：'.$good_id);
                    }
                    foreach ($request->input('sku_id'.$good_id) as $key => $v) {
                        // $sku_tmp['sku_id'] = $request->input('sku_str'.$good_id)[$key];
                        $sku_tmp['sku_id'] = $v;
                        if (empty(floatval($request->input('price'.$v)))) {
                            throw new CustomException('请完善优惠活动的商品信息，商品id：'.$good_id);
                        }
                        $sku_tmp['price'] = $request->input('price'.$v);
                        $sku_tmp['created_at'] = Carbon::now()->toDateTimeString();
                        $promotion_goods_sku[] = $sku_tmp;
                    }
                    $good_tmp['status'] = 1;
                    $promotion_goods[] = $good_tmp;
                }
                $pre_num = $request->input($request->activity_type.'_pre_num');
                break;
            default:
                foreach($activity_goods as $val){
                    $good_id = $val->goods_id;
                    $good_tmp['id'] = $val->id;
                    if($request->input('per_num'.$good_id) !== null) {
                        $good_tmp['per_num'] = $request->input('per_num'.$good_id);
                        $good_tmp['num'] = $request->input('num'.$good_id) ?? 0;
                        foreach($request->input('sku_id'.$good_id) as $key => $v){
                            $sku_tmp['activity_id'] = $request->id;
                            $sku_tmp['goods_id'] = $good_id;
                            $sku_tmp['sku_id'] = $request->input('sku_str'.$good_id)[$key];
                            if($request->input('price'.$v) !== null && empty(floatval($request->input('price'.$v)))) {
                                throw new CustomException('请完善优惠活动的商品信息，商品id：'.$good_id);
                            }
                            $sku_tmp['price'] = $request->input('price'.$v);
                            $sku_tmp['created_at'] = Carbon::now()->toDateTimeString();
                            $promotion_goods_sku[] = $sku_tmp;
                        }
                    } else {
                        $good_tmp['per_num'] = 0;
                        $good_tmp['num'] = 0;
                    }
                    $good_tmp['status'] = 1;
                    $good_ids[] = $good_id;
                    $promotion_goods[] = $good_tmp;
                }
                break;
        }
        return compact('promotion_goods', 'promotion_goods_sku', 'good_ids');
    }

    /**
     * @function 添加促销商品
     * @param $request
     * @return bool
     */
    public function addGoods($request)
    {
        $good_ids = explode(',', $request->good_id);
        try {
            DB::beginTransaction();
            $good_info = $this->product->findWhereIn('id', $good_ids);
            foreach ($good_info as $good) {
                $tmp['activity_id'] = $request->activity_id;
                $tmp['goods_id'] = $good->id;
                $tmp['status'] = 1;
                $tmp['created_at'] = Carbon::now()->toDateTimeString();
                $data[] = $tmp;
                $this->promotionGood->create($tmp);
            }
            DB::commit();
            $type = $request->type;
            $view = view('promotion.good_sku_list', compact('good_info', 'type'));
            $goods_sku_str = response($view)->getContent();
            return ApiResponse::success($goods_sku_str);
        } catch (\Exception $e) {
            ding('促销活动'.$request->activity_id.'添加商品失败'.$e->getMessage());
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '添加活动商品失败，请稍后重试或者联系管理员');
        }
    }

    /**
     * @function 删除促销商品
     * @param $request
     * @return mixed
     */
    public function delGoods($request)
    {
        $good_ids = explode(',', $request->good_id);
        try {
            DB::beginTransaction();
            $this->promotionGood->makeModel()->whereIn('goods_id', $good_ids)->where('activity_id', $request->activity_id)->delete();
            DB::commit();
            return ApiResponse::success('', '删除活动商品成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '删除活动商品失败，请稍后重试或者联系管理员');
        }
    }

    /**
     * @function 获取可添加的促销活动商品
     * @param $activity_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAblePromotionActivityGoods($activity_id, $request)
    {
        //获取所有已参加活动的商品
        $activity_good_ids = $this->promotionGood->findWhere(['activity_id' => $activity_id])->pluck('goods_id')->toArray();
        //获取所有商品列表
        $this->product->pushCriteria(new ProductTitleCriteria($request->good_title));
        $this->product->pushCriteria(new ProductIdCriteria($request->good_id));
        $this->product->pushCriteria(new ProductCodeCriteria($request->good_code));
        $this->product->pushCriteria(new ProductNotIdCriteria($activity_good_ids));
        $this->product->pushCriteria(new ProductStatusCriteria(Product::ONLINE));
        $goods = $this->product->orderBy('id', 'desc')->paginate(10);
        $addGoods = view('promotion.addGoods', compact('goods'));
        $goodStr = response($addGoods)->getContent();
        return $goodStr;
    }

    public function getGoodsWithSku($goods, $type){
        if(empty($goods)) return '';
        $good_ids = $goods->pluck('id');
        $data['goods'] = $goods;
        $data['type'] = $type;
        $goodSkuStr = compact('goods', 'type');
        return $goodSkuStr;
    }

    /**
     * @function 获取已添加的促销活动商品
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPromotionActivityGoods($request)
    {
        //获取所有已参加活动的商品
        $activity_good_ids = $this->promotionGood->findWhere(['activity_id' => $request->id])->pluck('id')->toArray();
        //获取所有商品列表
        $this->product->pushCriteria(new ProductTitleCriteria($request->good_title));
        $this->product->pushCriteria(new ProductIdCriteria($activity_good_ids));
        $this->product->pushCriteria(new ProductCodeCriteria($request->good_code));
        $goods = $this->product->orderBy('id', 'desc')->paginate(10);
        $goodStr = view('promotion.addGoods', compact('goods'));
        return $goodStr;
    }

    /**
     * @function 获取单个sku的页面信息
     * @param $request
     * @return mixed
     */
    public function getSingleSkuHtml($request)
    {
        $good_id = $request->good_id;
        $activity_id = $request->activity_id;
        if (! $good_id || ! $activity_id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要设置是商品');
        }
        $activityGoods = $this->promotionGood->findWhere(['goods_id' => $good_id, 'activity_id' => $activity_id]);
        if (! $activityGoods) {
            return ApiResponse::failure(g_API_ERROR, '请重新选择要设置的商品');
        }
        $good = $this->product->find($good_id);
        $goodSkus = $good->getGood->getSkus;
        $skuHtml = view('promotion.singlesku', compact('goodSkus'));
        $html=response($skuHtml)->getContent();
        return ApiResponse::success($html);
    }

    public function deletePromotion($id)
    {
        try {
            DB::beginTransaction();
            //删除促销活动
            $this->promotion->delete($id);
            //删除促销活动商品
            $this->promotionGood->deleteWhere(['activity_id' => $id]);
            //删除促销活动商品SKU
            $this->promotionGoodSku->deleteWhere(['activity_id' => $id]);
            DB::commit();
            return ApiResponse::success('删除成功');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('促销活动删除失败'.$e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '删除失败');
        }
    }
}
