<?php

namespace App\Http\Controllers\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\CategoryAttribute;
use App\Http\Requests\CateAttr\CategoryRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $id = $request->get('id');
        $result = Category::all();
        $attributes = Attribute::all();
        $category_attr_all = CategoryAttribute::all();
        $category_attrs = array();
        $category = array();
        foreach($result as $k => &$row){
            if($id){
                if($id == $row->id) $cate_info = $row;
            }
            $path_arr = explode(',', $row->category_ids);
            switch(count($path_arr)){
                case 1:
                    $category[0][$row->id] = $row;
                    break;
                case 2:
                    $parent_id = array_pop($path_arr);
                    $category[1][$parent_id][$row->id] = $row;
                    $category[1][$row->id] = $row;
                    break;
                case 3:
                    $parent_id = array_pop($path_arr);
                    $category[2][$parent_id][$row->id] = $row;
                    $category[2][$row->id] = $row;
                    break;
            }
            foreach($category_attr_all as &$value){
                if($row->id == $value['category_id']){
                    foreach($attributes as &$attr_value){
                        if($attr_value->id == $value['attr_id']){
                            $value['attr_title'] = $attr_value->name;
                            $value['attr_alias_title'] = $attr_value->alias_name;
                            $value['attr0_type'] = $attr_value->type;
                        }
                    }
                    $category_attrs[$row->id][$value['id']] = $value;
                }
            }
        }
        $cate_info = isset($cate_info) ? $cate_info : array();
        $data['category'] = json_encode($category);
        $data['category_attrs'] = json_encode($category_attrs);
        $data['cate_info'] = json_encode($cate_info);
        return view('cateAttr.category', $data);
    }

    /**
     * 创建分类
     */
    public function create(CategoryRequest $request)
    {
        $data['name'] = $request->name;
        $data['en_name'] = $request->en_name;
        $data['sort'] = $request->sort;
        if (! $request->laval1) {
            $data['level'] = 1;
        } else if (! $request->laval2) {
            $data['level'] = 2;
        } else {
            $data['level'] = 3;
        }
        switch ($data['level']) {
            case 2:
                $parent_info = Category::find($request->laval1);
                if (! $parent_info) {
                    return jsonMessage('laval1###请重新选择类目!');
                }
                $data['category_ids'] = $parent_info->category_ids.','.$request->laval1;
                $data['parent_id'] = $parent_info->id;
                break;
            case 3:
                $parent_info = Category::find($request->laval2);
                if (! $parent_info) {
                    return jsonMessage('laval2###请重新选择类目!!');
                }
                if ($parent_info->is_final == 1) {
                    return jsonMessage('该类目为叶子类目，不允许有子类目');
                }
                $data['category_ids'] = $parent_info->category_ids.','.$request->laval2;
                $data['parent_id'] = $parent_info->id;
                $data['is_final'] = 1;
                break;
            default:
                $data['category_ids'] = 0;
                $data['parent_id'] = 0;
                break;
        }
        if (Category::insert($data)) {
            return jsonMessage('', '创建成功');
        }
        return jsonMessage('创建失败');
    }

    /**
     * 修改分类
     */
    public function update(CategoryRequest $request)
    {
        $data['id'] = $request->id;
        $data['name'] = $request->name;
        $data['sort'] = $request->sort;
        if ($request->final) {
            $data['is_final'] = $request->final;
        }
        $data['status'] = $request->status;
        $categorys = Category::where('id', $data['id'])->orWhere('parent_id', $data['id'])->get();
        if (! $categorys) {
            return jsonMessage('请重新选择节点！');
        }
        if ($request->final) {
            if ($categorys[0]['level'] == 1 || count($categorys) > 1) {
                return jsonMessage('该节点不允许设置为叶子节点');
            }
        }
        $attribute = $request->attribute;
        if (! $attribute) {
            if (Category::where('id', $request->id)->update($data)) {
                return jsonMessage('', '修改成功');
            }
            return jsonMessage('修改失败');
        }
        if($categorys[0]['is_final'] == 0 && empty($data['is_final'])) return jsonMessage('非叶子节点不允许添加属性');
        try {
            DB::beginTransaction();
            Category::where('id', $data['id'])->update($data);
            $attribute = json_decode($attribute, true);
            if ($attribute) {
                foreach ($attribute as $k => &$v) {
                    if (! $v) continue;
                    $v['category_id']= $request->id;
                    if (isset($v['id']) && $v['id']) {
                        if (isset($v['is_delete'])) {
                            CategoryAttribute::destroy($v['id']);
                        } else {
                            unset($v['attr_title']);
                            unset($v['attr_alias_title']);
                            unset($v['attr0_type']);
                            CategoryAttribute::where('id', $v['id'])->update($v);
                        }
                    } else {
                        $v['created_at'] = Carbon::now()->toDateTimeString();
                        CategoryAttribute::insert($v);
                    }
                }
            }
            DB::commit();
            return jsonMessage('', '修改成功!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return jsonMessage('修改失败！');
        }
    }

    /**
     * 分类搜索
     */
    public function search(Request $request)
    {
        $name = $request->title;
        if (! $name) return jsonMessage('请输入要搜索的分类名称！');
        $result = Category::where('name', 'like','%'.$name.'%')->orderBy('category_ids', 'desc')->get();
        return jsonMessage('', $result);
    }

    /**
     * 修改分类属性值
     */
    public function value(Request $request)
    {
        if (! $id = $request->id) return jsonMessage('请选择要修改的分类属性值');
        $updateData = $request->only(['id', 'attr_values', 'is_required', 'check_type', 'is_image', 'is_image', 'is_detail']);
        if (CategoryAttribute::where('id', $id)->update($updateData)) {
            return jsonMessage('', '修改成功');
        }
        return jsonMessage('修改失败');
    }
}
