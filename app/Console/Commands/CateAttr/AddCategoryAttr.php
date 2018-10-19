<?php

namespace App\Console\Commands\CateAttr;

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
        $attr_value_ids = [
            '23022',
            '24265',
            '24266'
        ];
        $category = [
            1 => [172],
            2 => [],
            3 => []
        ];
        foreach ($category as $level => $category_ids)
        {
            if ($level == 1) {
                //获取所有的二级类目
                $category_two = Category::whereIn('parent_id', $category_ids)->pluck('id');
                // 获取所有的三级类目
                $category_three = Category::whereIn('parent_id', $category_two)->pluck('id');
                foreach ($category_three as $id) {
                    $category_attribute = CategoryAttribute::where(['category_id' => $id, 'attr_id' => $attr_id])->first();
                    if (! $category_attribute->attr_values) {
                        ding($id.'-'.$attr_id);
                        die;
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
