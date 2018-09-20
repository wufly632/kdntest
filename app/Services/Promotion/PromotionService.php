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

use App\Repositories\Promotion\PromotionRepository;

class PromotionService
{
    /**
     * @var PromotionRepository
     */
    protected $promotion;

    /**
     * PromotionController constructor.
     *
     * @param PromotionRepository $good
     */
    public function __construct(PromotionRepository $promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @function 获取促销活动列表
     */
    public function getList()
    {
        $this->promotion->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        return $this->promotion->orderBy($orderBy, $sort)->paginate($length);
    }
}
