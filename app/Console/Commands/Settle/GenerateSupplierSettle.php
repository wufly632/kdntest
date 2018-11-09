<?php

namespace App\Console\Commands\Settle;

use Illuminate\Console\Command;

class GenerateSupplierSettle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:supplier_settle {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每月定时生成商家结算单';

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
        
    }
}
