<?php
// +----------------------------------------------------------------------
// | SyncCategory.php
// +----------------------------------------------------------------------
// | Description: 批量插入商品属性
// +----------------------------------------------------------------------
// | Time: 2018/10/4 下午3:32
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Console\Commands;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\Category;
use App\Entities\CateAttr\CategoryAttribute;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncCategoryAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:category_attribute  {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量商品分类属性';

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
        $arr = [
            // '户外运动属性.xlsx',
            // '居家百货属性.xlsx',
            // '汽车配饰属性.xlsx',
            // '手机数码属性.xlsx',
            // '美妆个护.xlsx',
            // '服装服饰类目.xlsx',
            // '孕婴童.csv',
            // '箱包配饰.xlsx'
            // '类目增加.xlsx',
            '办公用品类目.xlsx',
            '椅子.xlsx',
        ];
        foreach ($arr as $i) {
            $excel_path = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import/attribute'.DIRECTORY_SEPARATOR.$i;
            \Excel::load($excel_path, function ($reader) use ($i) {
                // 中文属性
                $reader1 = $reader->getSheet(0);
                $ch    = $reader1->toArray();
                foreach ($ch as $key => $item) {
                    if ($key == 0) continue;
                    if (! $item[0]) continue;
                    $this->info($i.'-'.$key);
                    //类目
                    $category_name_one = $item[0];
                    $category_one_ids = Category::where('name', $category_name_one)->pluck('id')->toArray();
                    $category_name_two = $item[1];
                    $category_two_ids = Category::where(['name'=> $category_name_two, 'level' => 2])->whereIn('parent_id', $category_one_ids)->pluck('id')->toArray();
                    $category_name_three = $item[2];
                    $category_id = Category::where(['name' => $category_name_three, 'level' => 3])->whereIn('parent_id', $category_two_ids)->first()->id;
                    //属性名
                    $attr_name = $item[5];
                    $attr_id = Attribute::where('name', $attr_name)->first()->id;
                    $type = $item[4] == 3 ? 2 : 1;//(非)标准属性
                    if ($type == 2) {
                        $attr_values = '';
                    } else {
                        $attr_values_name = array_filter(array_slice($item, 7));
                        $attr_values = AttributeValue::whereIn('name', $attr_values_name)->where('attribute_id', $attr_id)->pluck('id')->implode(',');
                    }
                    //属性类型
                    $attr_type = $item[3];
                    $check_type = $item[4] == 2 ? 1 : 2;//单选/多选
                    $category_attr_data = [
                        'category_id' => $category_id,
                        'attr_type' => $attr_type,
                        'attr_id' => $attr_id,
                        'attr_values' => $attr_values,
                        'is_required' => 1,
                        'check_type'  => $check_type,
                        'is_diy' => 2,
                        'status' => 1,
                        'created_at' => Carbon::now()->toDateTimeString()
                    ];
                    if ($attr_type == 3 && $attr_name == '颜色') {
                        $category_attr_data['is_image'] = 1;
                    }
                    CategoryAttribute::updateOrCreate(['attr_id' => $attr_id, 'category_id' => $category_id],$category_attr_data);
                    $this->info($attr_name.'完成');
                }
            });
            $this->info($i.'-finish!');
        }
        $this->info('finish!');
    }

}
