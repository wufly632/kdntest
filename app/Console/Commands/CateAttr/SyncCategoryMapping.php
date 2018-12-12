<?php

namespace App\Console\Commands\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncCategoryMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:category_mapping {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入类目属性筛选表数据';

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
        //
        if ($this->option('y')) {
            $this->handleProgress();
        } else {
            if ($this->confirm('Do you want to continue? [y|N]')) {
                $this->handleProgress();
            }
        }
    }

    public function handleProgress()
    {
        $files = [
            '类目属性筛选.xlsx'
        ];
        foreach ($files as $file) {
            $path = storage_path('excel/import/' . $file);
            \Excel::load($path, function ($reader) use ($file) {
                foreach ($reader->getSheetNames() as $i => $category_name) {
                    $category_attributes = $reader->getSheet($i)->toArray();
                    $category_id = Category::where(['level' => 1, 'name' => $category_name])->first()->id;
                    $mapData = [];
                    foreach ($category_attributes as $key => $category_attribute) {
                        $tmp = [];
                        if (! $key || ! $category_attribute[1]) continue;
                        $tmp['category_id'] = $category_id;
                        if ($category_attribute[0]) {
                            $tmp['attr_name'] = Attribute::find($category_attribute[0])->en_name;
                            if (! AttributeValue::find($category_attribute[2])) {
                                continue;
                            }
                            $tmp['attr_value'] = AttributeValue::find($category_attribute[2])->en_name;
                        } else {
                            $tmp['attr_name'] = $category_attribute[1];
                            $tmp['attr_value'] = $category_attribute[3];
                        }

                        $tmp['attr_type'] = 4;
                        $tmp['check_type'] = 2;
                        $tmp['created_at'] = Carbon::now()->toDateTimeString();
                        $mapData[] = $tmp;
                    }
                    \DB::table('category_attrvalue_mapping')->insert($mapData);
                    $this->info($category_name.'导入完成');
                }
            });
        }
    }
}