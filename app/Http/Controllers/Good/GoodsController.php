<?php

namespace App\Http\Controllers\Good;

use App\Entities\CateAttr\Category;
use App\Entities\Good\Good;
use App\Entities\Supplier\SupplierUser;
use App\Repositories\Good\GoodRepositoryEloquent;
use App\Services\Api\ApiResponse;
use App\Services\CateAttr\CategoryAttributeService;
use App\Services\Good\GoodService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class GoodsController.
 *
 * @package namespace App\Http\Controllers\Good;
 */
class GoodsController extends Controller
{
    /**
     * @var GoodService
     */
    protected $goodService;

    /**
     * @var CategoryAttributeService
     */
    protected $categoryAttributeService;


    public function __construct(GoodService $goodService,CategoryAttributeService $categoryAttributeService)
    {
        $this->goodService = $goodService;
        $this->categoryAttributeService = $categoryAttributeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flash();
        $goods = $this->goodService->getList($request);
        $suppliers = SupplierUser::all();
        return view('goods.index', compact('goods','suppliers'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function audit(Good $good)
    {
        //获取该分类对应的类目属性
        $categoryAttributes = $this->categoryAttributeService->getCategoryAttribute($good->category_id);

        //获取该类目下对应的图片属性id
        $picAttributeId = $this->categoryAttributeService->getPicAttributeId($good->category_id);
        $goodSkus = $good->getSkus;

        $good->good_sku_image = $this->goodService->getProductSkuImage($goodSkus, $good->category_id);
        // 分类信息
        $cate = Category::find($good->category_id);
        // 获取商品类目下的所有非标准属性
        $notstandardAttr = $this->categoryAttributeService->getNotStandardAttr($good->category_id,$good->getAttrValue);
        return view('goods.audit', compact('categoryAttributes', 'picAttributeId', 'goodSkus', 'good', 'cate', 'notstandardAttr'));
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
        $result = $this->goodService->auditPass($request);
        if ($result) {
            return ApiResponse::success('审核通过成功');
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
        $result = $this->goodService->auditReject($request);
        if ($result) {
            return ApiResponse::success('审核拒绝成功');
        }
        return ApiResponse::failure(g_API_ERROR, '审核拒绝失败，请重试');
    }

    /**
     * 退回修改
     */
    public function auditReturn(Request $request)
    {
        if (! $id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请先选择商品');
        }
        $result = $this->goodService->auditReturn($request);
        return $result;
    }

    /**
     * @function 商品编辑
     * @param Request $request
     * @return mixed
     */
    public function editPost(Request $request)
    {
        if (! $id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要修改的商品');
        }
        return $this->goodService->editPost($request);
    }

    /**
     * @function 商品排序
     * @param Request $request
     */
    public function sort(Request $request)
    {
        if (! $id = $request->id) {
            return ApiResponse::failure(g_API_ERROR, '请选择要排序的商品');
        }
        return $this->goodService->sortGood($request);
    }

    public function showMoretime(Good $good)
    {
        return view('goods.moretime', compact('good'));
    }

}
