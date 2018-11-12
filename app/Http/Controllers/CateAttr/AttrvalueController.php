<?php

namespace App\Http\Controllers\CateAttr;

use App\Services\Api\ApiResponse;
use App\Services\CateAttr\AttrValueService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttrvalueController extends Controller
{

    protected $attrValueService;

    protected $users = [
        'wufly@cucoe.com',
        'wfxykzd@163.com',
        'yingfei.zou@waiwaimall.com',
        'long.hao@waiwaimall.com',
    ];

    public function __construct(AttrValueService $attrValueService)
    {
        $this->attrValueService = $attrValueService;
    }

    /**
     * @function 属性值增加或删除
     * @param Request $request
     * @return mixed
     */
    public function updateOrInsert(Request $request)
    {
        if(!in_array(Auth::user()->email, $this->users)){
            return ApiResponse::failure(g_API_ERROR, '权限受限!');
        }
        $model = $this->attrValueService->getAttributeValueRepository()->makeModel();
        if($request->id){
            $model = $model->where('id', '!=', $request->id);
        }
        if($model->where('attribute_id', $request->attribute_id)->where('name', $request->name)->first()){
            return ApiResponse::failure(g_API_ERROR, '属性值名称有重复');
        }
        if($model->where('attribute_id', $request->attribute_id)->where('en_name', $request->en_name)->first()){
            return ApiResponse::failure(g_API_ERROR, '属性值英文名称有重复');
        }
        $attribute_value = $this->attrValueService->getAttributeValueRepository()->updateOrCreate(['id' => $request->id], $request->all());
        if(!$attribute_value){
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
        $attribute =  $this->attrValueService->getAttributeRepository()->find($attribute_value->attribute_id);
        $attribute_values = $attribute->attribute_values;
        if ($attribute_value->wasRecentlyCreated){
            return ApiResponse::success($attribute_values, "成功添加属性值:".$attribute_value->name);
        } else {
            return ApiResponse::success($attribute_values, "成功修改属性值:".$attribute_value->name);
        }
    }

    /**
     * @function 删除属性值
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $attrvalue_id = $request->id;
        if(!$attrvalue_id){
            return ApiResponse::failure(g_API_ERROR,'参数缺失!');
        }
        return ApiResponse::failure(g_API_ERROR, '属性值不允许删除，请联系技术人员');
    }
}
