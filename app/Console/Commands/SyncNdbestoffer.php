<?php

namespace App\Console\Commands;

use App\Entities\CateAttr\Category;
use App\Entities\Supplier\SupplierUser;
use App\Traits\HttpRequestTrait;
use Illuminate\Console\Command;

class SyncNdbestoffer extends Command
{

    use HttpRequestTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ndbestoffer {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync ndbestoffer website product';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        //
        if ($this->option('y')) {
            $this->handleProgress();
        } else {
            if ($this->confirm('Do you want to continue? [y|N]')) {
                $this->handleProgress();
            }
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function handleProgress()
    {
        $supplierId = $this->getSupplierId();
        $uri = 'http://219.135.103.230:8088/external_interface/syn_api.html';
        $params = [
            'interface_type' => 'prod_data_syn_api',
            'mch_id' => '9082AE35AD861D8327F053CEDD53B1A1',
            'synTimestamp' => '1000000000'
        ];
        \Cache::put('sync_ndbest_offer', time(), 43200);
        $res = $this->makePostRequest($uri, $params)['result'];
        foreach ($res as $item) {

        }
    }

    protected function getSupplierId()
    {
        $supplier = SupplierUser::firstOrCreate(['name' => 'ndbestoffer']);
        if (!$supplier->email) {
            $supplier->email = 'ndbestoffer';
        }
        if (!$supplier->password) {
            $supplier->password = \Hash::make('Ww123456');
        }
        $supplier->save();
        return $supplier->id;
    }
}
