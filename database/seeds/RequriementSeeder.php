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
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $tmp = [];
            $tmp['sku_id'] = rand(1, 10);
            $tmp['num'] = rand(-20,30);
            $tmp['type'] = rand(1,2);
            $tmp['is_push'] = rand(0,1);
            $tmp['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $data[] = $tmp;
        }
        \DB::table('requirements')->insert($data);
    }
}
