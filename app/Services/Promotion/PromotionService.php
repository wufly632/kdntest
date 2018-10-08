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

use App\Entities\Coupon\Coupon;
use App\Entities\Product\ProductSku;
use App\Exceptions\CustomException;
use App\Repositories\Promotion\PromotionGoodRepository;
use App\Repositories\Promotion\PromotionGoodSkuRepository;
use App\Repositories\Promotion\PromotionRepository;
use App\Services\Api\ApiResponse;
use App\Validators\Promotion\PromotionGoodValidator;
use App\Validators\Promotion\PromotionValidator;
use Carbon\Carbon;
use Clockwork\Request\Log;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * PromotionController constructor.
     *
     * @param PromotionRepository $good
     */
    public function __construct(
        PromotionRepository $promotion, PromotionValidator $promotionValidator,
        PromotionGoodRepository $promotionGood, PromotionGoodValidator $promotionGoodValidator,
        PromotionGoodSkuRepository $promotionGoodSku
    )
    {
        $this->promotion = $promotion;
        $this->promotionValidator = $promotionValidator;
        $this->promotionGood = $promotionGood;
        $this->promotionGoodValidator = $promotionGoodValidator;
    }

    /**
     * @function 获取促销活动列表
     */
    public function getList()
    {
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
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
            // $this->promotionValidator->with( $request->all() )->passesOrFail();
            $promotion = $this->transform($request);
            DB::beginTransaction();
            $this->promotion->update($promotion['promotion'], $request->id);
            /*foreach ($promotion['promotion_goods'] as $promotion_good) {
                $this->promotionGood->update($promotion_good, $promotion_good->id);
            }
            if ($promotion['promotion_goods']['promotion_goods_sku']) {
                $this->promotionGoodSku->create($promotion['promotion_goods']['promotion_goods_sku']);
            }*/
            DB::commit();
            return ApiResponse::success('保存成功');
        } catch (ValidationException $e) {
            DB::rollback();
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    private function transform($request)
    {
        $promotion['promotion'] = $request->only(['id','title','activity_type','is_all','pre_time']);
        $promotion['promotion']['stock'] = 0;
        list($start_time,$end_time) = get_time_range($request->promotion_time);
        if ($request->pre_time) {
            $promotion['promotion']['pre_time'] = $request->pre_time;
            $start_time = Carbon::parse($start_time);
            $promotion['promotion']['show_at'] = $start_time->subDays($request->pre_time)->toDateTimeString();
        } else {
            $promotion['promotion']['show_at'] = $start_time;
        }
        $promotion['promotion']['end_at'] = $end_time;
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
               return $activity_good->num*$activity_good->getProduct->getProductSkus->max('supply_price');
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
                    throw new CustomException('促销价不能大于售价');
                    break;
                }
            }
        }
        $promotion['promotion']['goods_value'] = $goodsValue;
        $promotion['promotion'] = array_merge($promotion['promotion'], $promotion_type_info);
        $promotion['promotion_goods'] = [];
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
                $price_sum = Coupon::whereIn('id', implode(',', $request->return_ids))->sum('coupon_price');

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
                    if (! $request->input('num'.$good_id)) {
                        throw new CustomException('请完善优惠活动的商品信息，商品id：'.$good_id);
                    }
                    $good_tmp['num'] = $request->input('num'.$good_id);
                    $stock += $request->input('num'.$good_id);

                    $sku_tmp['activity_id'] = $request->id;
                    $sku_tmp['goods_id'] = $good_id;
                    if (empty($request->input('sku_id'.$good_id))) {
                        throw new CustomException('请重新添加商品，商品id：'.$good_id);
                    }
                    foreach ($request->input('sku_id'.$good_id) as $key => $v) {
                        $sku_tmp['sku_id'] = $request->input('sku_str'.$good_id)[$key];
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
                /*foreach($activity_goods as $val){
                    $good_id = $val->goods_id;
                    $good_tmp['id'] = $val->id;
                    if($request->per_num.$good_id !== null) {
                        $good_tmp['per_num'] = $request->input('per_num'.$good_id);
                        $good_tmp['num'] = $request->input('num'.$good_id) ?? 0;
                        foreach($request->input('sku_id'.$good_id) as $key => $v){
                            $sku_tmp['activity_id'] = $request->id;
                            $sku_tmp['goods_id'] = $good_id;
                            $sku_tmp['sku_id'] = $request->input('sku_str'.$good_id)[$key];
                            if(empty(floatval($request->input('price'.$v)))) {
                                throw new CustomException('请完善优惠活动的商品信息，商品id：'.$good_id);
                            }
                            $sku_tmp['price'] = $request->input('price'.$v);
                            $sku_tmp['created_at'] = Carbon::now()->toDateTimeString();
                            $promotion_goods_sku[] = $sku_tmp;
                        }
                    }
                    $good_tmp['status'] = 1;
                    $good_ids[] = $good_id;
                    $promotion_goods[] = $good_tmp;
                }*/
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
        $good_ids = $request->good_id;
        try {
            DB::beginTransaction();
            foreach (explode(',', $good_ids) as $good) {
                $tmp['activity_id'] = $request->activity_id;
                $tmp['goods_id'] = $good;
                $tmp['status'] = 1;
                $tmp['created_at'] = Carbon::now()->toDateTimeString();
                $data[] = $tmp;
                $this->promotionGood->create($tmp);
            }
            DB::commit();
            return ApiResponse::success('', '添加活动商品成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '添加活动商品失败，请稍后重试或者联系管理员');
        }
    }

    public function getGoodsList($activity_id)
    {

    }

    public function getPromotionActivityGoods($activity_id)
    {
        $result = DB::table('promotions_activity_goods as pag')
            ->leftJoin('goods as g','g.id','=','pag.goods_id')
            ->selectRaw('g.*')
            ->where('pag.activity_id', $activity_id)
            ->get();
        return $result;
    }
}
