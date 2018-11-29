<?php

namespace App\Console\Commands\CateAttr;

use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\CategoryAttribute;
use Illuminate\Console\Command;

class AddCategoryAttr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:category_attribute {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量增加商品的分类属性值';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('y'))
        {
            $this->handleProgress();
        }else{
            if ($this->confirm('Do you want to continue? [y|N]')) {
                $this->handleProgress();
            }
        }
    }

    public function handleProgress()
    {
        $attr_id = 6;//颜色
        $attr_value_ids = AttributeValue::where('attribute_id', 6)->where('id', '<', 25033)->pluck('id')->toArray();
        $category = [
            1 => [1182, 1237, 1258, 1300, 1419, 1511],
            2 => [],
            3 => []
        ];
        // 排除的类目
        $excepte_cates = [
            1 => [],
            2 => [],
            3 => []
        ];
        $except_ids = [];
        // 查找所有排除的类目
        foreach ($excepte_cates as $level => $excepte_cate) {
            if ($level == 1) {
                //获取所有的二级类目
                $except_category_two = Category::whereIn('parent_id', $excepte_cate)->pluck('id')->toArray();
                // 获取所有的三级类目
                $except_category_three = Category::whereIn('parent_id', $except_category_two)->pluck('id')->toArray();
            } elseif ($level == 2) {
                // 获取所有的三级类目
                $except_category_three = Category::whereIn('parent_id', $excepte_cate)->pluck('id')->toArray();
            } elseif ($level == 3) {
                $except_category_three = $excepte_cate;
            }
            $except_ids = array_merge($except_ids, $except_category_three);
        }
        foreach ($category as $level => $category_ids)
        {
            if ($level == 1) {
                //获取所有的二级类目
                $category_two = Category::whereIn('parent_id', $category_ids)->pluck('id');
                // 获取所有的三级类目
                $category_three = Category::whereIn('parent_id', $category_two)->pluck('id');
                foreach ($category_three as $id) {
                    $category_attribute = CategoryAttribute::where(['category_id' => $id, 'attr_id' => $attr_id])->first();
                    if (! isset($category_attribute->attr_values)) {
                        ding($id.'-'.$attr_id);
                        continue;
                    }
                    $attr_values = array_unique(array_merge(explode(',', $category_attribute->attr_values), $attr_value_ids));
                    $category_attribute->attr_values = implode(',', $attr_values);
                    if ($category_attribute->save()) {
                        $this->info($id.'成功');
                    } else {
                        ding($id."添加属性值失败");
                    }
                }
            }
        }
        $this->comment('finish');
    }
}
