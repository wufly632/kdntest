<?php

namespace App\Console\Commands\Product;

use App\Entities\CateAttr\Category;
use App\Entities\Good\Good;
use App\Entities\Product\Product;
use App\Entities\User\SupplierUser;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ExportAllProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:all_product {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导出所有的商品';

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
        \Excel::create('all_product'.date('md'), function (LaravelExcelWriter $writer) {
            $this->info('start...');
            $writer->sheet('Sheet1', function(LaravelExcelWorksheet $sheet) {
                $heading = array(
                    "ID",
                    "一级类目",
                    "二级类目",
                    "三级类目",
                    "商品名称",
                    "商家名称",
                    "商品状态",
                    "上架状态",
                    "供货价",
                    "售价",
                    "一级返利",
                    "二级返利",
                    "创建时间",
                    "上架时间"
                );
                $sheet->row(1, $heading);// set header
                $index = 2;
                $width = [10,30,30,30,30,10,10,30,10,10,10,10,30,30];
                foreach (range('A', 'N') as $key => $char) {
                    $sheet->setWidth($char, $width[$key]);
                }
                $sheet->setColumnFormat([
                    'A' => '@',
                    'B' => '@',
                    'C' => '@'
                ]);
                // 查找所有商品
                $goods = Good::all();
                foreach ($goods as $good) {
                    $data = [];
                    $data[] = $good->id;
                    $category_path = explode(',', $good->category_path);
                    $data[] = Category::where('id', $category_path[1])->first()->name;
                    $data[] = Category::where('id', $category_path[2])->first()->name;
                    $data[] = Category::where('id', $category_path[3])->first()->name;
                    $data[] = $good->good_title;
                    $data[] = SupplierUser::where('id', $good->supplier_id)->first()->name;
                    $data[] = Good::$allStatus[$good->status];
                    $product = $good->getProduct;
                    $data[] = $product ? Product::$allStatus[$product->status] : '';
                    $data[] = $good->supply_price;
                    $data[] = $product->price ?? '';
                    $data[] = $product->rebate_level_one ?? '';
                    $data[] = $product->rebate_level_two ?? '';
                    $data[] = $good->created_at;
                    $data[] = $product->shelf_at ?? '';
                    $sheet->row($index,$data);
                    $index++;
                }
            });
        })->store('xlsx');
        $this->info('end');
    }
}
