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
        for ($i=1;$i<3;$i++) {
            $excel_path = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR.iconv("UTF-8", 'GBK', $i.'-attribute').'.xlsx';
            \Excel::load($excel_path, function ($reader) {
                $reader1 = $reader->getSheet(0);
                //中文属性和属性值
                $ch    = $reader1->toArray();
                //英文属性和属性值
                $reader2 = $reader->getSheet(1);
                $en = $reader2->toArray();
                foreach ($ch as $key => $attribute_info) {
                    if ($key == 0) continue;
                    //属性
                    if ($attribute = Attribute::where('name', $attribute_info[3])->first()) {
                        $attribute_id = $attribute->id;
                    } else {
                        $attribute_data = [
                            'name' => $attribute_info[3],
                            'alias_name' => $attribute_info[3],
                            'en_name' => $en[$key][3],
                            'type' => 1, //标准化文本
                            'status' => 1,
                            'created_at' => Carbon::now()->toDateTimeString()
                        ];
                        $attribute_id = Attribute::insertGetId($attribute_data);
                    }
                    //属性值
                    foreach (array_slice($attribute_info, 4) as $k => $value) {
                        if (! $value) continue;
                        if (! $attr_value = AttributeValue::where(['attribute_id' => $attribute_id, 'name' => $value])->first()) {
                            $attr_data = [
                                'attribute_id' => $attribute_id,
                                'name' => $value,
                                'en_name' => $en[$key][$k+3],
                                'created_at' => Carbon::now()->toDateTimeString()
                            ];
                            AttributeValue::insertGetId($attr_data);
                        }
                    }
                }

            });
        }
    }

}
