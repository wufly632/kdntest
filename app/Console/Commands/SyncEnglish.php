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

class SyncEnglish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:english  {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量同步英文信息';

    protected $ch_info;

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
            '孕婴童.csv' => '孕婴童1.csv',
        ];
        foreach ($arr as $ch => $en) {
            $excel_path_ch = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import/attribute'.DIRECTORY_SEPARATOR.$ch;
            $excel_path_en = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import/attribute'.DIRECTORY_SEPARATOR.$en;
            \Excel::load($excel_path_ch, function ($reader) {
                // 中文信息
                $reader1 = $reader->getSheet(0);
                $this->ch_info    = $reader1->toArray();
            });
            \Excel::load($excel_path_en, function ($reader) {
                // 英文信息
                $reader1 = $reader->getSheet(0);
                $en    = $reader1->toArray();

                foreach ($this->ch_info as $key => $ch) {
                    if (! $key) continue;
                    //翻译类目
                    //一级类目
                    $category_one = Category::where(['name' => $ch[0], 'level' => 1])->first();
                    $category_one->en_name = $en[$key][0];
                    $category_one->save();
                    // 二级类目
                    $category_two = Category::where(['name' => $ch[1], 'level' => 2])->first();
                    $category_two->en_name = $en[$key][1];
                    $category_two->save();
                    // 三级类目
                    $category_three = Category::where(['name' => $ch[2], 'level' => 3])->first();
                    $category_three->en_name = $en[$key][2];
                    $category_three->save();
                    // 翻译属性
                    $attribute = Attribute::where(['name' => $ch[5]])->first();
                    $attribute->en_name = $en[$key][5];
                    $attribute->save();
                    //属性值翻译
                    foreach ($ch as $k => $va) {
                        if ($k < 7) continue;
                        if ( !$va) continue;
                        $attr_value = AttributeValue::where(['attribute_id' => $attribute->id, 'name' => $va])->first();
                        $attr_value->en_name = $en[$key][$k];
                        $attr_value->save();
                    }
                    $this->info($ch.'-'.$key.'-'.$attribute->name.'完成');
                }
            });
        }
        $this->info('finish!');
    }

}
