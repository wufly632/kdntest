<?php

namespace App\Console\Commands\Product;

use App\Entities\Good\Good;
use App\Entities\Product\Product;
use Illuminate\Console\Command;

class FixProductSupplyPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:product_supply_price {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修复商品的供货价与sku供货价不一致';

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
        $goods = Good::all();
        foreach ($goods as $good) {
            $supply_price = $good->getSkus()->min('supply_price');
            if ($supply_price != $good->supply_price)
            {
                $good->supply_price = $supply_price;
                $good->save();
            }
        }
        $products = Product::all();
        foreach ($products as $product) {
            $supply_price = $product->productSku()->min('supply_price');
            if ($supply_price != $product->supply_price)
            {
                $product->supply_price = $supply_price;
                $product->save();
            }
        }
        $this->info('end!');
    }
}
