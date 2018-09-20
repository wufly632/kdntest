<?php

namespace App\Http\Controllers\CateAttr;

use App\Entities\CateAttr\AttributeValue;
use App\Http\Requests\CateAttr\AttrvalueRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttrvalueController extends Controller
{
    /**
     * 创建属性值
     */
    public function create(AttrvalueRequest $request)
    {
        if (AttributeValue::insert($request->except('_token'))) {
            return jsonMessage('', '添加成功！');
        }
        return jsonMessage('添加失败！');
    }

    /**
     * 更新属性值
     */
    public function update(AttrvalueRequest $request)
    {
        $id = $request->id;
        if (AttributeValue::where('id', $id)->update($request->except(['id', '_token']))) {
            return jsonMessage('','更新成功');
        }
        return jsonMessage('更新失败');
    }

    /**
     * 搜索
     */
    public function search(Request $request)
    {
        $name = $request->name;
        $id   = $request->id;
        if (! $name) return jsonMessage('请输入要搜索的属性名称');
        if (! $id) return jsonMessage('请选择属性');
        $result = AttributeValue::where([['attribute_id', $id], ['name', $name]])->get();
        return jsonMessage('', $result);
    }

    /**
     * 属性值详情
     */
    public function detail(Request $request)
    {
        $id = $request->id;
        if (! $id) return jsonMessage('请选择要查询的属性');
        $result = AttributeValue::whereIn('id', explode(',' ,$id))->get();
        return jsonMessage('', $result);
    }
}
