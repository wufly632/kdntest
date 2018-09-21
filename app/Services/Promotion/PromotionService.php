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
use App\Services\Api\ApiResponse;
use App\Validators\Promotion\PromotionValidator;
use Carbon\Carbon;
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
     * PromotionController constructor.
     *
     * @param PromotionRepository $good
     */
    public function __construct(PromotionRepository $promotion, PromotionValidator $promotionValidator)
    {
        $this->promotion = $promotion;
        $this->promotionValidator = $promotionValidator;
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
        $data = $request->only(['title', 'start_at', 'end_at']);
        $data['user_id'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        if ($promotion = $this->promotion->create($data)) {
            return ApiResponse::success($promotion->id);
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
            $this->promotionValidator->with( $request->all() )->passesOrFail();
            $promotion = $this->transform($request);
            DB::beginTransaction();
            $this->promotion->create($promotion['promotion']);
            DB::commit();
        } catch (ValidationException $e) {
            DB::rollback();
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    private function transform($request)
    {
        $promotion['promotion'] = $request->only(['id']);
    }
}
