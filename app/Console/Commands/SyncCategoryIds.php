<?php

namespace App\Console\Commands;

use App\Entities\CateAttr\Category;
use Illuminate\Console\Command;

class SyncCategoryIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:category_ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //获取所有的一级类目
        $category_one = Category::where('level', 1)->get();
        foreach ($category_one as $one) {
            //获取下一级类目
            $category_two = Category::where('parent_id', $one->id)->get();
            foreach ($category_two as $two) {
                $two->category_ids = '0,'.$one->id;
                $two->save();
                $category_three = Category::where('parent_id', $two->id)->get();
                foreach ($category_three as $three) {
                    $three->category_ids =  '0,'.$one->id.','.$two->id;
                    $three->save();
                    $this->info($three->id.' finish');
                }
            }
        }
    }
}
