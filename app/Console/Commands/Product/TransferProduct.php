<?php

namespace App\Console\Commands\Product;

use App\Entities\Good\Good;
use App\Entities\Product\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:product_by_category {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '根据类目归属迁移商品';

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
        $ascriptions = DB::table('category_ascription as a')
            ->leftJoin('admin_users as b', 'b.id', '=', 'a.admin_user_id')
            ->selectRaw('a.*,b.supplier_id')
            ->get();
        foreach ($ascriptions as $ascription) {
            $category_id = $ascription->category_id;
            $supplier_id = $ascription->supplier_id;
            if ($supplier_id == 1) continue;
            Good::where('category_path', 'like', '0,'.$category_id.',%')->where('supplier_id', 1)->update(['supplier_id' => $supplier_id]);
            Product::where('category_path', 'like', '0,'.$category_id.',%')->where('supplier_id', 1)->update(['supplier_id' => $supplier_id]);
            $this->info($category_id.' end');
        }
        $this->info('finish');
    }
}
