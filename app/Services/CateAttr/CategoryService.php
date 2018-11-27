<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */

namespace App\Services\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\Good\Good;
use App\Entities\Product\Product;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Repositories\CateAttr\CategoryRepository;
use App\Services\Api\ApiResponse;
use App\Services\Product\ProductService;
use Carbon\Carbon;
use DB;

class CategoryService
{

    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * @var CategoryAttributeRepository
     */
    protected $categoryAttribute;
    protected $productService;

    /**
     * GoodsController constructor.
     *
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category, CategoryAttributeRepository $categoryAttribute, ProductService $productService)
    {
        $this->category = $category;
        $this->categoryAttribute = $categoryAttribute;
        $this->productService = $productService;
    }

    public function getCategoryRepository()
    {
        return $this->category;
    }

    public function getCategoryAttributeModel()
    {
        return $this->categoryAttribute->makeModel();
    }

    /**
     * 获取父分类下面的子分类
     *
     * @param int $parent_id
     * @return mixed
     */
    public function getCategoriesByParentId(int $parent_id)
    {
        return $this->category->makeModel()->all()->where('parent_id', $parent_id);
    }

    /**
     * 获取类目属性
     *
     * @param int $category_id 分类id
     * @param int $type type
     * @return json
     */
    public function getCategoryAttributes(int $category_id, $type = '')
    {
        $collections = $this->getCategoryAttributeModel()->where('category_id', $category_id)->where('status', '1');
        if ($type && !empty($type)) {
            $collections = $collections->where('attr_type', $type);
        }
        $categoryAttributes = $collections->groupBy('attr_id')->groupBy('attr_type')->orderBy('id')->get();
        return $categoryAttributes;
    }

    /**
     * 转换类目属性原始值
     *
     * @param object $categoryAttributes 类目属性
     * @param int $type type
     * @return json
     */
    public function transformCategoryAttributes($categoryAttributes)
    {
        $apiAttributeService = app(AttributeService::class);
        $datas = [];
        foreach ($categoryAttributes as $categoryAttribute) {
            //获取类目属性
            $attribute = $apiAttributeService->getAttributeByPk($categoryAttribute->attr_id);
            $tmp_attribute['id'] = $categoryAttribute->attr_id;
            $tmp_attribute['attr_type'] = $categoryAttribute->attr_type;
            $tmp_attribute['name'] = $attribute->name;
            if (!isset($datas[$categoryAttribute->attr_type])) {
                $datas[$categoryAttribute->attr_type] = [];
            }
            $datas[$categoryAttribute->attr_type][] = $tmp_attribute;
        }
        return $datas;
    }

    /**
     * @function 获取下一级类目
     * @param int $category_id
     * @return mixed
     */
    public function getSubCategories(int $category_id)
    {
        return $this->category->findWhere(['parent_id' => $category_id]);
    }

    /**
     * @function 新增/修改分类
     * @param $request
     */
    public function updateOrInsert($request)
    {
        try {
            DB::beginTransaction();
            $category_id = empty($request->category_id) ? 0 : $request->category_id;
            $data['name'] = $request->name;
            $data['en_name'] = $request->en_name;
            $data['sort'] = $request->sort;
            $data['is_final'] = $request->is_final;
            $data['describe'] = $request->describe;
            $data['parent_id'] = $this->getParentId($category_id, $request->first_level_category, $request->second_level_category);
            if ($data['parent_id'] == 0) {
                $data['level'] = 1;
            } elseif ($data['parent_id'] == $request->first_level_category) {
                $data['level'] = 2;
            } elseif ($data['parent_id'] == $request->second_level_category) {
                $data['level'] = 3;
            }
            $data['status'] = 1;
            if ($category_id) {
                $data['updated_at'] = Carbon::now()->toDateTimeString();
            } else {
                $data['create_at'] = Carbon::now()->toDateTimeString();
            }
            $category = $this->category->updateOrCreate(['id' => $category_id], $data);
            //生成类目ID路径
            $category_ids = $this->generateCategoryIds($category->id);
            $category = $this->category->update(['category_ids' => $category_ids], $category->id);
            DB::commit();
            return ApiResponse::success('操作成功');
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }

    }

    /**
     * 获取选中的父分类，判断是一级还是二级分类
     *
     * @param int $category_id 分类id
     * @param int $first_level_category 一级分类id
     * @param int $second_level_category 二级分类id
     * @return int
     */
    public function getParentId($category_id = 0, int $first_level_category, int $second_level_category)
    {
        $parent_id = 0;
        if ($first_level_category < 0) {
            return $parent_id;
        }
        if ($first_level_category == $category_id) {
            return $parent_id;
        }

        if ($second_level_category < 0) {
            return $parent_id = $first_level_category;
        }
        //如果category id存在说明是修改
        if ($category_id && strlen($category_id) > 0) {
            $category = $this->category->find($category_id);
            $parent_id = $category->parentCategory->parentCategory ? $second_level_category : $first_level_category;
        } else {
            $parent_id = $second_level_category;
        }

        return $parent_id;
    }

    /**
     * @function 生成类目路径
     * @param $category_id
     * @return string
     */
    public function generateCategoryIds($category_id)
    {
        $category_ids = '';
        $category = $this->category->find($category_id);
        if (!$category) {
            return $category_ids;
        }
        if ($category->level == 1) {
            $category_ids = '0';
        } else {
            $parent_category = $this->category->find($category->parent_id);
            $category_ids = $parent_category->category_ids . ',' . $category->parent_id;
        }
        return $category_ids;
    }

    /**
     * 获取当前类目信息
     *
     * @param int $category_id 分类id
     * @return json
     */
    public function getCategoryInfo(int $category_id)
    {
        $datas = [];
        $category = $this->category->find($category_id);
        //循环拿到所有的上级类目
        while ($category) {
            $datas[] = $category;
            $category = $category->parentCategory;
        }
        $current_category_first_level = end($datas);
        $result['current_first_level_category'] = $current_category_first_level;
        if (count($datas) > 1) {
            $current_category_second_level = $datas[count($datas) - 2];
            $result['current_second_level_category'] = $current_category_second_level;
            $result['second_level_categories'] = $current_category_first_level->subCategories->toArray();
        }
        return $result;
    }

    /**
     * 获取类目属性详情
     *
     * @param int $category_id 分类id
     * @param int $attribute_id 属性id
     * @return json
     */
    public function getCategoryAttributeDetail(int $category_id, int $attribute_id)
    {
        //获取类目属性
        $attribute = app(AttributeService::class)->getAttributeByPk($attribute_id);
        //获取类目属性对应的所有属性值
        if ($attribute->type == 2) {
            $attribute_values = [];
        } else {
            $attribute_values = app(AttrValueService::class)->getAttributeValuesByAttributeId($attribute_id, 'sort', 'desc', true);
        }

        //获取属性对应的属性值名称
        $category_attributes = $this->categoryAttribute->findWhere(['category_id' => $category_id, 'attr_id' => $attribute_id, 'status' => 1])->first();
        //组合数据
        $items = $category_attributes ? $category_attributes->formatExport() : [];
        // dd($category_attributes);
        $values = app(AttrValueService::class)->attribute_value_names($category_attributes);
        $items[] = ['name' => '属性名', 'value' => $attribute->name];
        $items[] = ['name' => '属性英文名', 'value' => $attribute->en_name];
        $items[] = ['name' => '属性值类型', 'value' => Attribute::$alltypes[$attribute->type]];
        $items[] = ['name' => '属性值', 'value' => implode(', ', array_pluck($values, 'name'))];
        $data['attribute_items'] = $items;
        $data['attribute_exist_values_id'] = array_pluck($values, 'id');
        $data['attribute_values'] = $attribute_values;
        $data['is_image'] = $values ? $values[0]['is_image'] : 2;
        $data['is_diy'] = $values ? $values[0]['is_diy'] : 2;
        $data['check_type'] = $values ? $values[0]['check_type'] : 2;
        $data['is_required'] = $values ? $values[0]['is_required'] : 2;
        $data['is_detail'] = $values ? $values[0]['is_detail'] : 1;
        $data['is_custom_text'] = $attribute->type;
        return $data;
    }

    /**
     * 更新类目属性
     *
     * @param Request $request
     * @return json
     */
    public function updateCategoryAttribute($request)
    {
        /*if ($request->type == 3) { // 销售属性
            // 判断该类目下是否有商品
            if (Good::where('category_id', $request->category_id)->first()) {
                return ApiResponse::failure(g_API_ERROR, '该类目下已有商品，不允许修改销售属性');
            }
        }*/
        $attribute = app(AttributeService::class)->getAttributeByPk($request->attribute_id);
        $data = [
            'category_id' => $request->category_id,
            'attr_type' => $request->type,
            'attr_id' => $request->attribute_id,
            'is_required' => $request->is_required,
            'is_image' => $request->is_image,
            'is_diy' => $request->is_diy,
            'is_detail' => $request->is_detail,
            'created_at' => Carbon::now()->toDateTimeString(),
        ];
        if ($attribute->type == 1) {//标准化属性
            $data['attr_values'] = implode(',', $request->values_id);
            $data['check_type'] = $request->check_type;
        } else {
            $data['attr_values'] = '';
            $data['check_type'] = 0;
        }
        try {
            DB::beginTransaction();
            $this->categoryAttribute->updateOrCreate(['category_id' => $request->category_id, 'attr_id' => $request->attribute_id], $data);
            DB::commit();
            return ApiResponse::success('', '操作成功!');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    public function getCategoryByLevel($level, $field = ['*'])
    {
        return $this->category->findWhere(['level' => $level], $field);
    }

    /**
     * @function 删除类目
     * @param $category
     * @return mixed
     */
    public function deleteCategory($category)
    {
        // 判断该目录是否存在商品
        if ($category->level == 1) {
            $category_twos = $this->category->findWhere(['parent_id' => $category->id])->pluck('id')->toArray();
            $category_ids = $this->category->findWhereIn('parent_id', $category_twos)->pluck('id')->toArray();
            $category_ids = array_merge($category_twos, $category_ids);
        } elseif ($category->level == 2) {
            $category_ids = $this->category->findWhere(['parent_id' => $category->id])->pluck('id')->toArray();
            $category_ids[] = $category->id;
        } else {
            $category_ids = [$category->id];
        }
        if (Good::whereIn('category_id', $category_ids)->first()) {
            return ApiResponse::failure(g_API_ERROR, '该类目下存在商品，不允许删除');
        }
        try {
            DB::beginTransaction();
            CategoryAttribute::whereIn('category_id', $category_ids)->delete();
            Category::whereIn('id', $category_ids)->delete();
            DB::commit();
            return ApiResponse::success('操作成功');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info('类目' . $category->id . '删除失败-' . $e->getMessage());
            ding('类目' . $category->id . '删除失败-' . $e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

    /**
     * 根据商品分类path获取分类名称
     * @param $ids
     * @return string
     */
    public function getCateNameByIds($ids)
    {
        $ids = explode(',', $ids);
        array_shift($ids);
        $cates       = $this->category->findWhereIn('id', $ids);
        $cateNameStr = '';
        foreach ($cates as $cate) {
            $cateNameStr .= $cate->name;
            $cateNameStr .= ' ';
        }
        return $cateNameStr;
    }

    /**
     * 获取某一类目下的商品数量
     * @param $categoryId
     * @return mixed
     */
     /*
     * 删除类目属性
     *
     * @param Request $request
     * @return json
     */
    public function deleteCategoryAttribute($request)
    {
        // 判断该类目下是否有商品
        if (Good::where('category_id', $request->category_id)->first()) {
            return ApiResponse::failure(g_API_ERROR, '该类目下已有商品，不允许删除');
        }
        try {
            DB::beginTransaction();
            $this->categoryAttribute->deleteWhere(['category_id' => $request->category_id, 'attr_id' => $request->attribute_id]);
            DB::commit();
            return ApiResponse::success('操作成功!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info('商品属性删除失败-'.$e->getMessage());
            ding('商品属性删除失败-'.$e->getMessage());
            return ApiResponse::failure(g_API_ERROR, '操作失败');
        }
    }

    /**
     * @function 类目搜索
     * @param $name
     * @return mixed
     */
    public function searchCategory($name)
    {
        $name = strtolower($name);
        $categories = $this->category->findWhere([['name', 'like', '%'.$name.'%']]);
        $categoriesLikeName = [];
        foreach ($categories as $category) {
            $categoriesLikeName[$category->id] = $category->name;
            if ($paCategory = $category->parentCategory) {
                $categoriesLikeName[$paCategory->id] = $paCategory->name . ' > ' . $category->name;
                if ($paPaCategory = $paCategory->parentCategory) {
                    $categoriesLikeName[$paPaCategory->id] = $paPaCategory->name . ' > '.$paCategory->name . ' > ' . $category->name;
                }
            }
        }
        return $categoriesLikeName;
    }

    public function getCategoryProductSum($categoryId)
    {
        return $this->productService->checkProductCountByCateIds($this->getAllLevelThree($categoryId));

    }

    /**
     * 获取所有第三级ID
     * @param $categoryId
     * @return array
     */
    public function getAllLevelThree($categoryId)
    {
        $cate = $this->category->find($categoryId);
        if ($cate->is_final == 1) {
            return [$cate->id];
        } else {
            return $this->getNextLevelAllCateId([$cate->id]);
        }
    }

    /**
     * 获取下级所有ID
     * @param array $categoryIds
     * @return array
     */
    public function getNextLevelAllCateId(Array $categoryIds)
    {
        $cate = $this->category->findWhereIn('parent_id', $categoryIds);
        if ($cate[0]->level == 3) {
            return array_pluck($cate->toArray(), 'id');
        } else {
            return $this->getNextLevelAllCateId(array_pluck($cate->toArray(), 'id'));
        }
    }

    public function getCateByName($name)
    {
        return $this->category->model()::where('name', $name)->where('level', 3)->first();
    }
}