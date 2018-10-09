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
        $arr = [4];
        foreach ($arr as $i) {
            $excel_path = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR.iconv("UTF-8", 'GBK', $i.'-category_attribute').'.csv';
            \Excel::load($excel_path, function ($reader) use ($i) {
                //中文销售属性
                /*$reader1 = $reader->getSheet(0);
                $ch    = $reader1->toArray();
                foreach ($ch as $key => $category_attr) {
                    if ($key == 0) continue;
                    if (!$category_attr[0]) continue;
                    $category_name_one = $category_attr[0];
                    $category_one_ids = Category::where('name', $category_name_one)->pluck('id')->toArray();
                    $category_name_two = $category_attr[1];
                    $category_two_ids = Category::where(['name'=> $category_name_two, 'level' => 2])->whereIn('parent_id', $category_one_ids)->pluck('id')->toArray();
                    $category_name = $category_attr[2];
                    $this->info(implode(',', $category_two_ids));
                    $this->info($i.'-'.$key.'-'.$category_name);
                    $category_id = Category::where(['name' => $category_name, 'level' => 3])->whereIn('parent_id', $category_two_ids)->first()->id;
                    $attr_name = $category_attr[3];
                    $attr_id = Attribute::where('name', $attr_name)->first()->id;
                    $attr_values_name = array_filter(array_slice($category_attr, 4));
                    $attr_values = AttributeValue::whereIn('name', $attr_values_name)->where('attribute_id', $attr_id)->pluck('id')->implode(',');
                    $category_attr_data = [
                        'category_id' => $category_id,
                        'attr_type' => 3, //销售属性
                        'attr_id' => $attr_id,
                        'attr_values' => $attr_values,
                        'is_required' => 1,
                        'check_type'  => 1,//暂定多选
                        'is_diy' => 2,
                        'status' => 1,
                        'created_at' => Carbon::now()->toDateTimeString()
                    ];
                    if ($attr_name == '颜色') {
                        $category_attr_data['is_image'] = 1;
                    }
                    CategoryAttribute::updateOrCreate(['attr_id' => $attr_id, 'category_id' => $category_id],$category_attr_data);
                    $this->info($key.' end');
                }*/



                //中文非关键属性
                $reader1 = $reader->getSheet(0);
                $ch    = $reader1->toArray();
                foreach ($ch as $key => $category_attr) {
                    if ($key == 0) continue;
                    $category_attr = explode("\t", $category_attr[0]);
                    $category_name_one = $category_attr[0];
                    if (!$category_attr[0]) continue;
                    $category_one_ids = Category::where('name', $category_name_one)->pluck('id')->toArray();
                    $category_name_two = $category_attr[1];
                    $category_two_ids = Category::where(['name'=> $category_name_two, 'level' => 2])->whereIn('parent_id', $category_one_ids)->pluck('id')->toArray();
                    $category_name = $category_attr[2];
                    $this->info(implode(',', $category_two_ids));
                    $this->info($i.'.'.$key.'-'.$category_name);
                    $category_id = Category::where(['name' => $category_name, 'level' => 3])->whereIn('parent_id', $category_two_ids)->first()->id;
                    $attr_name = $category_attr[3];
                    $attr_id = Attribute::where('name', $attr_name)->first()->id;
                    $attr_values_name = array_filter(array_slice($category_attr, 4));
                    $attr_values = AttributeValue::whereIn('name', $attr_values_name)->where('attribute_id', $attr_id)->pluck('id')->implode(',');
                    $category_attr_data = [
                        'category_id' => $category_id,
                        'attr_type' => 4, //非关键属性
                        'attr_id' => $attr_id,
                        'attr_values' => $attr_values,
                        'is_required' => 1,
                        'check_type'  => 1,//暂定多选
                        'is_diy' => 2,
                        'status' => 1,
                        'created_at' => Carbon::now()->toDateTimeString()
                    ];
                    CategoryAttribute::updateOrCreate(['attr_id' => $attr_id, 'category_id' => $category_id],$category_attr_data);
                    $this->info($key.' end');
                }

            });
        }
    }

}
