<?php

namespace App\Http\Controllers\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\CategoryAttribute;
use App\Http\Requests\CateAttr\AttributeRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use DB,Log;

class AttributeController extends Controller
{
    public function index()
    {
        $attribute = $this ->get_all_attribute();
        return view('CateAttr.attribute', compact('attribute'));
    }

    /**
     * @function
     * @return false|string
     */
    protected function get_all_attribute()
    {
        $result = Attribute::all();
        $value_result = AttributeValue::all();
        $attribute = array();
        foreach($result as $k => $v){
            $attribute[0][$v->id] = $v;
            foreach($value_result as $key => $value){
                if($v->id == $value->attribute_id){
                    $attribute[$v->id][$value->id] = $value;
                }
            }
        }
        return json_encode($attribute);
    }

    public function create(AttributeRequest $request)
    {
        $id = DB::table('admin_attribute')->insertGetId([
            'name' => $request->name,
            'alias_name' => $request->alias_name,
            'en_name' => $request->en_name,
            'type' => $request->type,
            'sort' => $request->sort,
            'status' => 1,
            'created_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now(),
        ]);
        if ($id) {
            return response()->json([
                'status' => true,
                'messages' => '添加成功',
                'id' => 1
            ]);
        }
        return jsonMessage('添加失败');
    }


    public function attr(Request $request)
    {
        $id = $request->input('id');
        $attr_result = CategoryAttribute::where(['attr_id' => $id])->get();
        $cate_result = [];
        if(!empty($attr_result)){
            $cate = array();
            foreach($attr_result as $k => &$v){
                $cate[] = $v['category_id'];
            }
            $cate_result = Category::whereIn('id', $cate)->get();
        }
        return jsonMessage('', $cate_result);
    }

    /**
     * 属性搜索
     */
    public function search(Request $request)
    {
        $name = $request->name;
        if (! $name) {
            return jsonMessage('请输入要搜索的属性名称');
        }
        $result = Attribute::where('name', $name)->orWhere('alias_name', $name)->orderBy('sort', 'desc')->get();
        return jsonMessage('', $result);
    }

    /**
     * 更新属性
     */
    public function update(AttributeRequest $request)
    {
        $id = $request->id;
        if (! $id) {
            return jsonMessage('请选择要修改的属性');
        }
        $attribute['name'] = $request->name;
        $attribute['alias_name'] = $request->alias_name;
        $attribute['type'] = $request->type;
        $attribute['en_name'] = $request->en_name;
        $attribute['sort'] = $request->sort;
        if (Attribute::where(['id' => $id])->update($attribute)) {
            return jsonMessage('', '修改成功');
        }
        return jsonMessage('修改失败！');
    }

    /**
     * 删除属性
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        if ( !$id) {
            return jsonMessage('请选择要删除的属性');
        }
        if ($id == 1) {
            return jsonMessage('该属性不能删除');
        }
        $category_attr = CategoryAttribute::where('attr_id', $id)->first();
        if ($category_attr) {
            return jsonMessage('该属性已关联类目，不可删除');
        }
        try {
            DB::beginTransaction();
            Attribute::where('id', $id)->delete();
            AttributeValue::where('attribute_id', $id)->delete();
            DB::commit();
            return jsonMessage('', '删除成功');
        } catch (\Exception $e) {
            Log:error($e->getMessage());
            DB::rollback();
            return jsonMessage('删除失败');
        }
    }

    /**
     * 获取所有属性
     */
    public function all()
    {
        $attribute = $this->get_all_attribute();
        return jsonMessage('', $attribute);
    }
}