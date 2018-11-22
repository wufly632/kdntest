<?php

namespace App\Http\Controllers\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Services\Api\ApiResponse;
use App\Services\CateAttr\AttributeService;
use App\Http\Controllers\Controller;
use App\Services\CateAttr\CategoryAttributeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttributeController extends Controller
{

    protected $attributeService;

    protected $users = [
        'fei.wu@waiwaimall.com',
        'yingfei.zou@waiwaimall.com',
        'long.hao@waiwaimall.com',
    ];

    protected $add_users = [
        'fei.wu@waiwaimall.com',
        'yingfei.zou@waiwaimall.com',
        'long.hao@waiwaimall.com',
        'chengxi.luo@waiwaimall.com',
        'qiang.han@waiwaimall.com'
    ];

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * @function 属性列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $attribute_list = $this->attributeService->getAttributeRepository()->all();
        return view('cateAttr.attribute',['attribute_list'=>$attribute_list]);
    }

    /**
     * @function 属性详情
     * @param Attribute $attribute
     * @return mixed
     */
    public function detail(Attribute $attribute)
    {
        if(!$attribute){
            return ApiResponse::failure(g_API_ERROR,'参数缺失!');
        }
        $attribute->values = $attribute->attribute_values;
        $attribute->categories = $this->attributeService->getAttributeCategories($attribute->attribute_categories);
        if($attribute){
            return ApiResponse::success($attribute);
        } else {
            return ApiResponse::failure(g_API_ERROR, '没有详细数据');
        }
    }

    /**
     * @function 添加或编辑属性
     * @param Request $request
     * @return mixed
     */
    public function updateOrInsert(Request $request)
    {
        if(!in_array(Auth::user()->email, $this->add_users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
        if(!$attribute = $this->attributeService->getAttributeRepository()->updateOrCreate(['id'=> $request->id], $request->all())){
            return ApiResponse::failure(g_API_ERROR, '操作失败!');
        }
        if ($attribute->wasRecentlyCreated){
            //Created
            $attribute->isCreated = 1;
            return ApiResponse::success($attribute, "成功添加属性:".$attribute->name);
        } else {
            //Update
            $attribute->isCreated = 0;
            return ApiResponse::success($attribute, "成功更新属性:".$attribute->name);
        }
    }

    /**
     * @function 根据名称搜索属性
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $attributes = $this->attributeService->getAttributesByLikeName($request->name);
        return ApiResponse::success(compact('attributes'));
    }

    /**
     * @function 删除属性
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $attribute_id = $request->id;
        if(!$attribute_id){
            return ApiResponse::failure(g_API_ERROR,'参数缺失!');
        }
        if(!in_array(Auth::user()->email, $this->users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
        return $this->attributeService->deleteAttribute($attribute_id);
    }

    /**
     * 获取所有属性
     *
     * @param void
     * @return json
     */
    public function getAllAttributes()
    {
        $attributes = $this->attributeService->getAttributeRepository()->scopeQuery(function($query){
            return $query->orderBy('sort', 'desc');
        })->all()->toArray();
        return ApiResponse::success($attributes);
    }
}