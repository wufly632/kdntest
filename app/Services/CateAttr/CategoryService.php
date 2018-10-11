<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/19 上午11:47
 */
namespace App\Services\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Repositories\CateAttr\CategoryAttributeRepository;
use App\Repositories\CateAttr\CategoryRepository;
use App\Services\Api\ApiResponse;
use Carbon\Carbon;
use DB;

class CategoryService{

    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * @var CategoryAttributeRepository
     */
    protected $categoryAttribute;

    /**
     * GoodsController constructor.
     *
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category,CategoryAttributeRepository $categoryAttribute)
    {
        $this->category = $category;
        $this->categoryAttribute = $categoryAttribute;
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
            if (! isset($datas[$categoryAttribute->attr_type])) {
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
            echo $e->getMessage();die;
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
        if ($first_level_category === $category_id) {
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
        if (! $category) {
            return $category_ids;
        }
        if ($category->level == 1) {
            $category_ids = '0,'.$category_id;
        } else {
            $parent_category = $this->category->find($category->parent_id);
            $category_ids = $parent_category->category_ids.','.$category_id;
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
        $attribute_values = app(AttrValueService::class)->getAttributeValuesByAttributeId($attribute_id, 'sort', 'desc', true);

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
        $attribute = app(AttributeService::class)->getAttributeByPk($request->attribute_id);
        try {
            DB::beginTransaction();
            $data = [
                'category_id' => $request->category_id,
                'attr_type' => $request->type,
                'attr_id'   => $request->attribute_id,
                'attr_values' => implode(',', $request->values_id),
                'is_required' => $request->is_required,
                'check_type'  => $request->check_type,
                'is_image'    => $request->is_image,
                'is_diy'      => $request->is_diy,
                'is_detail'   => $request->is_detail,
                'created_at'  => Carbon::now()->toDateTimeString(),
            ];
            $this->categoryAttribute->updateOrCreate(['category_id' => $request->category_id, 'attr_id' => $request->attribute_id],$data);
            DB::commit();
            return ApiResponse::success('', '操作成功!');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }
}