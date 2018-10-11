<?php

namespace App\Console\Commands;

use App\Entities\CateAttr\Category;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:category {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导出所有的分类';

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

        \Excel::create('分类信息', function (LaravelExcelWriter $writer){

            $this->info('start...');
            $writer->sheet('Sheet1', function (LaravelExcelWorksheet $sheet) {
                $heading = array(
                    "一级类目ID",
                    "一级类目名称",
                    "一级类目英文",
                    "二级类目ID",
                    "二级类目名称",
                    "二级类目英文",
                    "三级类目ID",
                    "三级类目名称",
                    "三级类目英文",
                );
                $sheet->row(1, $heading);// set header
                $index = 2;
                $width = [10,30,30,10,30,30,10,30,30,10];
                foreach (range('A', 'I') as $key => $char) {
                    $sheet->setWidth($char, $width[$key]);
                }
                $sheet->setColumnFormat([
                    'A' => '@',
                    'B' => '@',
                    'E' => '@'
                ]);
                // 查找所有的一级类目
                $category_ones = Category::where(['level' => 1])->get();
                foreach ($category_ones as $category_one) {
                    // 查找该类目下的二级类目
                    $category_twos = Category::where(['parent_id' => $category_one->id])->get();
                    if ($category_twos) {
                        foreach ($category_twos as $category_two) {
                            // 查找所有的三级类目
                            $category_threes = Category::where(['parent_id' => $category_two->id])->get();
                            if ($category_threes) {
                                foreach ($category_threes as $category_three) {
                                    $sheet->row($index,
                                        [
                                            $category_one->id,
                                            $category_one->name,
                                            $category_one->en_name,
                                            $category_two->id,
                                            $category_two->name,
                                            $category_two->en_name,
                                            $category_three->id,
                                            $category_three->name,
                                            $category_three->en_name,
                                        ]
                                    );
                                    $index++;
                                }
                            } else {
                                $sheet->row($index,[
                                    $category_one->id,
                                    $category_one->name,
                                    $category_one->en_name,
                                    $category_two->id,
                                    $category_two->name,
                                    $category_two->en_name,
                                    '',
                                    '',
                                    '',
                                ]);
                                $index++;
                            }
                            $this->info($category_two->name.'完毕');
                        }
                    } else {
                        $sheet->row($index,[
                            $category_one->id,
                            $category_one->name,
                            $category_one->en_name,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                        ]);
                        $index++;
                    }
                    $this->info($category_one->name.'完毕');
                }
            });

        })->store('xlsx')/*->export('xlsx')*/;
        $this->info('end');
    }
}
