<?php

namespace App\Console\Commands\Product;

use App\Entities\Product\Product;
use Illuminate\Console\Command;

class SyncElasticsearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:elasticsearch {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '商品信息批量插入到elasticsearch中';

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

    private function handleProgress()
    {
        // 获取 Elasticsearch 对象
        $es = app('es');
        Product::query()
            ->where('status', 1)
            // 使用 chunkById 避免一次性加载过多数据
            ->chunkById(10, function ($products) use ($es) {
                $this->info(sprintf('正在同步 ID 范围为 %s 至 %s 的商品', $products->first()->id, $products->last()->id));
                // 初始化请求体
                $req = ['body' => []];
                // 遍历商品
                foreach ($products as $product) {
                    // 将商品模型转为 Elasticsearch 所用的数组
                    $data = $product->toESArray();
                    $req['body'][] = [
                        'index' => [
                            '_index' => 'products',
                            '_type'  => '_doc',
                            '_id'    => $data['id'],
                        ],
                    ];
                    $req['body'][] = $data;
                }
                try {
                    // 使用 bulk 方法批量创建
                    $es->bulk($req);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            });
        $this->info('同步完成');
    }
}
