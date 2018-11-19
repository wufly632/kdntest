<?php

namespace App\Http\Controllers\CateAttr;

use App\Entities\CateAttr\Category;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiResponse;
use App\Services\CateAttr\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * categoryService 注入到CategoryController的CategoryService
     *
     * @var string
     */
    protected $categoryService;

    protected $users = [
        'wufly@cucoe.com',
        'wfxykzd@163.com',
        'yingfei.zou@waiwaimall.com',
        'long.hao@waiwaimall.com',
    ];

    protected $add_users = [
        'wufly@cucoe.com',
        'wfxykzd@163.com',
        'yingfei.zou@waiwaimall.com',
        'long.hao@waiwaimall.com',
        'chengxi.luo@waiwaimall.com',
        'qiang.han@waiwaimall.com'
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
        if(!in_array(Auth::user()->email, $this->add_users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
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

    /**
     * 获取类目属性详情
     *
     * @param int $category_id 分类id
     * @param int $attribute_id 属性id
     * @return json
     */
    public function getCategoryAttributeDetail($category_id, $attribute_id)
    {
        if(!$attribute_id || !$category_id){
            return ApiResponse::failure(g_API_ERROR, '参数缺失!');
        }
        $data = $this->categoryService->getCategoryAttributeDetail($category_id, $attribute_id);
        return  ApiResponse::success($data);
    }

    /**
     * 更新类目属性
     *
     * @param Request $request
     * @return json
     */
    public function updateCategoryAttribute(Request $request)
    {
        if(!in_array(Auth::user()->email, $this->add_users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
        return $this->categoryService->updateCategoryAttribute($request);
    }

    /**
     * 检测类目图片属性是否存在
     *
     * @param Request $request
     * @return json
     */
    public function existCategoryPicAttribute(Request $request)
    {
        $category_id = $request->category_id;
        $attribute_id = $request->attribute_id;
        $categoryAttributeModel = $this->categoryService->getCategoryAttributeModel();
        $category_attribute = $categoryAttributeModel->where(['category_id' => $category_id, 'status' => 1, 'is_image' => 1])->first();
        if($category_attribute && $category_attribute->attribute_id != $attribute_id){
            return ApiResponse::failure(g_API_ERROR, '该分类已经存在相应的图片属性，是否重新定义该分类图片属性？');
        }
        return ApiResponse::success('');
    }

    /**
     * @function 获取类目下一级
     * @param Request $request
     * @return mixed
     */
    public function getNextLevel(Request $request)
    {
        $id = $request->id ?: 0;
        $category = $this->categoryService->getCategoryRepository()->makeModel()->where(['parent_id' => $id])->get(['id','name']);
        if ($category) {
            return ApiResponse::success($category);
        }
        return ApiResponse::failure(g_API_ERROR, '获取下一级类目失败');
    }

    /**
     * @function 删除类目
     * @param Category $category
     * @return mixed
     */
    public function delete(Category $category)
    {
        if (! $category) {
            return ApiResponse::failure(g_API_ERROR, '该类目不存在');
        }
        if(!in_array(Auth::user()->email, $this->users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
        return $this->categoryService->deleteCategory($category);
    }

    /**
     * @function 删除类目属性
     * @param Request $request
     * @return \App\Services\CateAttr\json|mixed
     */
    public function deleteCategoryAttribute(Request $request)
    {
        if(!in_array(Auth::user()->email, $this->users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
        return $this->categoryService->deleteCategoryAttribute($request);
    }


    /**
     * @function 类目搜索
     * @param Request $request
     * @return array|mixed
     */
    public function searchCategory(Request $request)
    {
        $name = $request->input('name', '');
        if (! $name) {
            return ApiResponse::success([]);
        }
        $categories = $this->categoryService->searchCategory($name);
        return ApiResponse::success($categories);
    }
}
