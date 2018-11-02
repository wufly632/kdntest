<?php

namespace App\Console\Commands\Product;

use App\Entities\Good\GoodSku;
use App\Entities\Product\Product;
use Illuminate\Console\Command;
use DB;

class ChangeProductPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:product_price {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量修改商品的售价';

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
        $category_ids = [798];
        $this->info('start...');
        foreach ($category_ids as $category_id)
        {
            //查找该类目下所有的商品
            $goods = Product::where('category_path', 'like', '0,'.$category_id.',%')->get();
            foreach($goods as $good) {
                DB::table('goods')->where('id', $good->id)->update(['price' => 0]);
                DB::table('audit_goods')->where('id', $good->id)->update(['price' => 0]);
                DB::table('good_skus')->where('good_id', $good->id)->update(['price' => 0]);
                DB::table('audit_good_skus')->where('good_id', $good->id)->update(['price' => 0]);
            }
        }
        $this->info('end...');
    }
}
