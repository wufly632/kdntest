<?php

namespace App\Console\Commands\CateAttr;

use App\Entities\CateAttr\Category;
use App\Entities\Good\Good;
use App\Entities\Product\Product;
use Illuminate\Console\Command;

class TransferCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:category {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '迁移类目';

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
        $cates = [
          866 => 990,//parent_id
          809 => 1867,
        ];
        foreach ($cates as $id => $parent_id)
        {
            $category = Category::find($id);
            if (! $category) continue;
            $category->parent_id = $parent_id;
            $cate_ids = explode(',', $category->category_ids);
            $cate_ids[count($cate_ids) - 1] = $parent_id;
            $category->category_ids = implode(',', $cate_ids);
            $category->save();
            // 修改商品表的路径
            Good::where('category_id', $id)->update(['category_path' => $category->category_ids.','.$id]);
            Product::where('category_id', $id)->update(['category_path' => $category->category_ids.','.$id]);
            $this->info($id.' finish');
        }
        $this->info('end');
    }
}
