<?php

use Illuminate\Database\Seeder;

class RequriementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sku_ids = \App\Entities\Good\GoodSku::all()->pluck('id')->toArray();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $tmp = [];
            $tmp['sku_id'] = $sku_ids[array_rand($sku_ids,1)];
            $tmp['num'] = rand(-20,30);
            $tmp['type'] = rand(1,2);
            $tmp['is_push'] = 0;
            $tmp['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $data[] = $tmp;
        }
        \DB::table('requirements')->insert($data);
    }
}
