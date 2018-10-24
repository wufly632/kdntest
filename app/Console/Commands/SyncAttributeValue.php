<?php
// +----------------------------------------------------------------------
// | SyncCategory.php
// +----------------------------------------------------------------------
// | Description: 批量插入属性和属性值
// +----------------------------------------------------------------------
// | Time: 2018/10/4 下午3:32
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Console\Commands;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncAttributeValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:attribute_and_value {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量插入属性和属性值';

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
            // '箱包配饰.xlsx',
            // '类目增加.xlsx',
            // '办公用品类目.xlsx',
            // '椅子.xlsx',
            // '本.xlsx',
            '灯具.xlsx',
            // '扩音器.xlsx',
        ];
        foreach ($arr as $i) {
            $excel_path = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import/attribute'.DIRECTORY_SEPARATOR.$i;
            \Excel::load($excel_path, function ($reader) use ($i) {
                $reader1 = $reader->getSheet(0);
                //中文属性和属性值
                $ch    = $reader1->toArray();
                //英文属性和属性值
                $reader2 = $reader->getSheet(1);
                $en      = $reader2->toArray();

                foreach ($ch as $key => $item) {
                    if ($key == 0) continue;
                    if (! $item[0]) continue;
                    $this->info($i.'-'.$key);
                    // 属性
                    $attr_name = $item[5];
                    if ($attribute = Attribute::where('name', $attr_name)->first()) {
                        $attribute_id = $attribute->id;
                    } else {
                        //属性类型（标准/非标准）
                        $type = $item[4] == 3 ? 2 : 1;
                        $attribute_data = [
                            'name' => $attr_name,
                            'alias_name' => $item[6],
                            'en_name' => ucwords(strtolower($en[$key][5])),
                            'type' => $type, //标准化文本
                            'status' => 1,
                            'created_at' => Carbon::now()->toDateTimeString()
                        ];
                        $attribute_id = Attribute::insertGetId($attribute_data);
                    }
                    // 属性值
                    foreach ($item as $k => $va) {
                        if ($k < 7) continue;
                        if (! $va) continue;
                        if ( !$attr_value = AttributeValue::where(['attribute_id' => $attribute_id, 'name' => $va])->first()) {
                            $attr_data = [
                                'attribute_id' => $attribute_id,
                                'name'         => $va,
                                'en_name'      => ucwords(strtolower($en[$key][$k])),
                                'created_at'   => Carbon::now()->toDateTimeString()
                            ];
                            AttributeValue::insertGetId($attr_data);
                        }
                    }
                    $this->info($attr_name.'完成');
                }
            });
            $this->info($i.'-finish!');
        }
        $this->info('finish!');
    }

}
