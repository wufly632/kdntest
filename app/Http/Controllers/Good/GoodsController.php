<?php

namespace App\Http\Controllers\Good;

use App\Entities\CateAttr\Category;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Repositories\CateAttr\CategoryAttributeRepositoryEloquent;
use App\Repositories\CateAttr\CategoryRepository;
use App\Repositories\Good\GoodRepositoryEloquent;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Good\GoodCreateRequest;
use App\Http\Requests\Good\GoodUpdateRequest;
use App\Repositories\Good\GoodRepository;
use App\Validators\Good\GoodValidator;
use App\Http\Controllers\Controller;

/**
 * Class GoodsController.
 *
 * @package namespace App\Http\Controllers\Good;
 */
class GoodsController extends Controller
{
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $orderBy = $request->orderBy ?? 'id';
        $sort = $request->sort ?? 'desc';
        $length = $request->length ?? 20;
        $goods = $this->repository->orderBy($orderBy, $sort)->paginate($length);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $goods,
            ]);
        }

        return view('goods.index', compact('goods'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function audit($id)
    {

        $good = $this->repository->find($id);

        //获取该分类对应的类目属性
        $categoryAttributes = app(CategoryAttributeRepositoryEloquent::class)->getCategoryAttribute($good->category_id);

        //获取该类目下对应的图片属性id
        $picAttributeId = app(CategoryAttributeRepositoryEloquent::class)->getPicAttributeId($good->category_id);
        $goodSkus = $good->getSkus;

        $good->good_sku_image = app(GoodRepositoryEloquent::class)->getProductSkuImage($goodSkus, $good->category_id);

        // 分类信息
        $cate = Category::find($good->category_id);
        return view('goods.audit', compact('categoryAttributes', 'picAttributeId', 'goodSkus', 'good', 'cate'));
    }

    /**
     * 审核通过
     */
    public function auditPass(Request $request)
    {
        if (! $id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请先选择商品');
        }
        // 同步商品数据
        $result = app(GoodRepositoryEloquent::class)->auditPass($request);
        if ($result) {
            return ApiResponse::success('', '审核通过成功');
        }
        return ApiResponse::failure(g_API_ERROR, '审核通过失败，请重试');
    }

    /**
     * 审核拒绝
     */
    public function auditReject(Request $request)
    {
        if (! $id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请先选择商品');
        }
        $result = app(GoodRepositoryEloquent::class)->auditReject($request);
        if ($result) {
            return ApiResponse::success('', '审核拒绝成功');
        }
        return ApiResponse::failure(g_API_ERROR, '审核拒绝失败，请重试');
    }

    /**
     * 退回修改
     */
    public function auditReturn(Request $request)
    {
        if (! $id = $request->id) {
            return jsonMessage('请先选择商品！');
        }
        $result = app(GoodRepositoryEloquent::class)->auditReturn($request);
        if ($result) {
            return jsonMessage('', '退回修改成功');
        }
        return jsonMessage('退回修改失败，请重试');
    }

}
