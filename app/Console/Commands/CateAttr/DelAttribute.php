<?php

namespace App\Console\Commands\CateAttr;

use App\Entities\CateAttr\Attribute;
use App\Entities\CateAttr\AttributeValue;
use App\Entities\CateAttr\CategoryAttribute;
use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Product\ProductAttrValue;
use Illuminate\Console\Command;

class DelAttribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:attribute {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除属性';

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
        $attributes = [124];//保修类型
        foreach ($attributes as $attribute) {
            // 删除属性
            Attribute::where('id', $attribute)->delete();
            // 删除属性值
            AttributeValue::where('attribute_id', $attribute)->delete();
            //删除类目属性
            CategoryAttribute::where('attr_id', $attribute)->delete();
            //删除商品属性值
            GoodAttrValue::where('attr_id', $attribute)->delete();
            ProductAttrValue::where('attr_id', $attribute)->delete();
        }
        $this->info('end');
    }
}
