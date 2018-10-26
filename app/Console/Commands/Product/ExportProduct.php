<?php

namespace App\Console\Commands\Product;

use App\Entities\CateAttr\Category;
use App\Entities\Product\Product;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:online_product {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导出类目下商品';

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
        \Excel::create('online_product'.date('md').'.xlsx', function (LaravelExcelWriter $writer) {
            $this->info('start...');
            $writer->sheet('Sheet1', function(LaravelExcelWorksheet $sheet) {
                $heading = array(
                    "一级类目",
                    "二级类目",
                    "三级类目",
                    "数量"
                );
                $sheet->row(1, $heading);// set header
                $index = 2;
                $width = [30,30,30,10];
                foreach (range('A', 'D') as $key => $char) {
                    $sheet->setWidth($char, $width[$key]);
                }
                $sheet->setColumnFormat([
                    'A' => '@',
                    'B' => '@',
                    'C' => '@'
                ]);
                //查找所有的一级类目
                $category_ones = Category::where(['level' => 1])->get();
                foreach ($category_ones as $category_one) {
                    // 查找该类目下的二级类目
                    $category_twos = Category::where(['parent_id' => $category_one->id])->get();
                    if ($category_twos) {
                        $category_one_sum = 0;
                        foreach ($category_twos as $category_two) {
                            $category_two_sum = 0;
                            // 查找该类目下的三级类目
                            $category_threes = Category::where(['parent_id' => $category_two->id])->get();
                            foreach ($category_threes as $category_three) {
                                // 查找该类目下的商品总数
                                $num = Product::where(['status' => 1, 'category_id' => $category_three->id])->count();
                                $sheet->row($index,
                                    [
                                        $category_one->name,
                                        $category_two->name,
                                        $category_three->name,
                                        $num,
                                    ]
                                );
                                $index++;
                                $category_two_sum += $num;
                            }
                            $sheet->row($index,
                                [
                                    $category_one->name,
                                    $category_two->name,
                                    '二级总数',
                                    $category_two_sum,
                                ]
                            );
                            $index++;
                            $index++;
                            $category_one_sum += $category_two_sum;
                        }
                        $sheet->row($index,
                            [
                                $category_one->name,
                                '一级总数',
                                '',
                                $category_one_sum,
                            ]
                        );
                        $index++;
                        $index++;
                    }
                }
            });
        })->store('xlsx')/*->export('xlsx')*/;
        $this->info('end');
    }
}
