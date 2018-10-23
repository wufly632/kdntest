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

use App\Entities\Good\Good;
use App\Entities\Product\Product;
use Illuminate\Console\Command;

class SyncGoodImg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:good_img  {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量修改商品的主图';

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
        // 获取所有商品
        $audit_goods = Good::all();
        foreach ($audit_goods as $audit_good) {
            $imgs = $audit_good->getImages->pluck('src')->toArray();
            if (! in_array($audit_good->main_pic, $imgs)) {
                Good::where('id', $audit_good->id)->update(['main_pic' => $imgs[0]]);
                Product::where('id', $audit_good->id)->update(['main_pic' => $imgs[0]]);
                $this->info($audit_good->id.' done');
            }
        }
        $this->info('finish!');
    }

}
