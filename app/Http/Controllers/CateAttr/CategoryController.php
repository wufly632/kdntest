<?php

namespace App\Http\Controllers\CateAttr;

use App\Http\Controllers\Controller;
use App\Services\Api\ApiResponse;
use App\Services\CateAttr\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * categoryService 注入到CategoryController的CategoryService
     *
     * @var string
     */
    protected $categoryService;

    private $users = [

    ];

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 列表页面
     *
     * @param void
     * @return mixed
     */
    public function index()
    {
        $categories = $this->categoryService->getCategoriesByParentId(0);
        return view('cateAttr.category', compact('categories'));
    }

    /**
     * @function 分类详情
     * @param $category_id
     * @return mixed
     */
    public function detail($category_id)
    {
        if(!$category_id){
            return ApiResponse::failure(g_API_ERROR,'参数缺失!');
        }
        $data = '';
        if($category = $this->categoryService->getCategoryRepository()->find($category_id)){
            $data = $category->toJson();
        } else {
            return ApiResponse::failure(g_API_ERROR,'类目不存在!');
        }

        return ApiResponse::success($data);
    }

    /**
     * 获取类目属性
     *
     * @param int $category_id 分类id
     * @return json
     */
    public function getCategoryAttributes(Request $request)
    {
        if(!$request->category_id){
            return ApiResponse::failure(g_API_ERROR, '参数缺失!');
        }
        //获取类目属性原始值
        $categoryAttributes = $this->categoryService->getCategoryAttributes($request->category_id, $request->type);
        //转换类目属性原始值
        $datas = $this->categoryService->transformCategoryAttributes($categoryAttributes);
        return ApiResponse::success($datas);
    }

    /**
     * 获取分类的子类目
     *
     * @param Request $request 注入请求
     * @return json
     */
    public function getSubCategories(Request $request)
    {
        $data = [];
        if($subCategories = $this->categoryService->getSubCategories($request->category_id)){
            $data = $subCategories->toArray();
        }

        return ApiResponse::success($data);
    }

    /**
     * @function 新增或更新类目
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $result = $this->categoryService->updateOrInsert($request);
        if ($result['status'] == 200) {
            return ApiResponse::success([], '保存成功');
        }
        return ApiResponse::failure(g_API_ERROR, '处理失败');
    }

    /**
     * 获取当前类目信息
     *
     * @param int $category_id 分类id
     * @return json
     */
    public function currentCategoryInfo($category_id)
    {
        if(!$category_id){
            return ApiResponse::failure(g_API_ERROR, '参数缺失!');
        }
        if($result = $this->categoryService->getCategoryInfo($category_id)){
            return ApiResponse::success($result);
        }else{
            return ApiResponse::success([]);
        }
    }
}
