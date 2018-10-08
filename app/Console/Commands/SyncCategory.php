<?php
// +----------------------------------------------------------------------
// | SyncCategory.php
// +----------------------------------------------------------------------
// | Description: 批量导入类目属性
// +----------------------------------------------------------------------
// | Time: 2018/10/4 下午3:32
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Console\Commands;

use App\Entities\CateAttr\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:category {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量插入类目信息';

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
            $excel_path = 'storage'.DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR.iconv("UTF-8", 'GBK', $i.'-category').'.xlsx';
            \Excel::load($excel_path, function ($reader) {
                $reader1 = $reader->getSheet(0);
                //中文分类
                $ch    = $reader1->toArray();
                //英文分类
                $reader2 = $reader->getSheet(1);
                $en = $reader2->toArray();
                foreach ($ch as $key => $category) {
                    if ($key == 0) continue;
                    //一级类目
                    $category_one = $category[0];
                    $category_two = $category[1];
                    $category_three = $category[2];
                    if (! $one = Category::where(['name' => $category_one, 'level' => 1])->first()) {
                        $one_data = [
                            'name' => $category_one,
                            'en_name' => $en[$key][0],
                            'category_ids' => 0,
                            'level' => 1,
                            'status' => 1,
                            'created_at' => Carbon::now()->toDateTimeString()
                        ];
                        $one_id = Category::insertGetId($one_data);
                    } else {
                        $one_id = $one->id;
                    }
                    if (! $two = Category::where(['name' => $category_two, 'level' => 2, 'parent_id' => $one_id])->first()) {
                        $two_data = [
                            'name' => $category_two,
                            'en_name' => $en[$key][1],
                            'category_ids' => '0,'.$one_id,
                            'level' => 2,
                            'parent_id' => $one_id,
                            'status' => 1,
                            'created_at' => Carbon::now()->toDateTimeString()
                        ];
                        $two_id = Category::insertGetId($two_data);
                    } else {
                        $two_id = $two->id;
                    }
                    if (! $three = Category::where(['name' => $category_three, 'level' => 3, 'parent_id' => $two_id])->first()) {
                        $three_data = [
                            'name' => $category_three,
                            'en_name' => $en[$key][2],
                            'category_ids' => '0,'.$one_id.','.$two_id,
                            'level' => 3,
                            'parent_id' => $two_id,
                            'status' => 1,
                            'is_final' => 1,
                            'created_at' => Carbon::now()->toDateTimeString()
                        ];
                        $three_id = Category::insertGetId($three_data);
                    } else {
                        $three_id = $three->id;
                    }
                    $this->info($one_id.','.$two_id.','.$three_id);
                }
            });
        }
    }

}
