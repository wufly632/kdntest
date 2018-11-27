<?php

namespace App\Console\Commands;

use App\Entities\Website\MobileCategory;
use App\Entities\Website\PcCategory;
use Illuminate\Console\Command;

class ImportCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:category';

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
        //
        $data = $this->getData();
        foreach ($data as $datum) {
            try {
                \DB::beginTransaction();
                $first = PcCategory::firstOrCreate(['name' => $datum['name'], 'category_id' => $datum['id']]);
                foreach ($datum['sub'] as $item) {
                    PcCategory::firstOrCreate(['name' => $item['name'], 'category_id' => $item['id'], 'parent_id' => $first->id]);
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                dd($e);
            }
            $this->info('success');
        }


    }

    public function getData()
    {
        $data = [
            [
                "id" => 1019,
                "name" => "Beauty",
                "sub" => [
                    [
                        "id" => 1020,
                        "name" => "Makeup Perfume",
                    ],
                    [
                        "id" => 1063,
                        "name" => "Beauty Tools",
                    ],
                    [
                        "id" => 1078,
                        "name" => "Facial Care",
                    ],
                    [
                        "id" => 1113,
                        "name" => "Body Care",
                    ],
                    [
                        "id" => 1126,
                        "name" => "Body Cleansing",
                    ],
                    [
                        "id" => 1053,
                        "name" => "Oral Care",
                    ]
                ]
            ],
            [
                "id" => 172,
                "name" => "Home & living",
                "sub" => [
                    [
                        "id" => 192,
                        "name" => "Kitchen Appliances",
                    ],
                    [
                        "id" => 223,
                        "name" => "Kitchen Tools",
                    ],
                    [
                        "id" => 276,
                        "name" => "Household Appliances",
                    ],
                    [
                        "id" => 317,
                        "name" => "Children's Room/table/chair/furniture",
                    ],
                    [
                        "id" => 334,
                        "name" => "Tableware",
                    ],
                    [
                        "id" => 374,
                        "name" => "Household Storage",
                    ],
                    [
                        "id" => 376,
                        "name" => "Household Cleaning",
                    ],
                    [
                        "id" => 432,
                        "name" => "Mosquito Protection",
                    ],
                    [
                        "id" => 445,
                        "name" => "Home Decoration",
                    ],
                    [
                        "id" => 1846,
                        "name" => "Rainy Day Supplies",
                    ]
                ]
            ],
            [
                'id' => 843,
                'name' => 'Electronic Devices',
                'sub' => [
                    [
                        "id" => 799,
                        "name" => "Cellular Phone",
                    ],
                    [
                        "id" => 808,
                        "name" => "Mobile Phone Cases",
                    ],
                    [
                        "id" => 802,
                        "name" => "Mobile Phone Charger",
                    ],
                    [
                        "id" => 803,
                        "name" => "Cellphone Data Line",
                    ],
                    [
                        "id" => 990,
                        "name" => "Data Storage",
                    ],
                    [
                        "id" => 812,
                        "name" => "Flat Products",
                    ],
                    [
                        "id" => 831,
                        "name" => "Laptop",
                    ],
                    [
                        "id" => 843,
                        "name" => "Digital Product",
                    ]
                ]
            ],
            [
                'id' => 1321,
                'name' => "Luggage",
                'sub' => [
                    [
                        "id" => 1410,
                        "name" => "Watch",
                    ],
                    [
                        "id" => 1353,
                        "name" => "Sunglasses",
                    ],
                    [
                        "id" => 1387,
                        "name" => "Necklace & Pendants",
                    ],
                    [
                        "id" => 1391,
                        "name" => "Earrings",
                    ],
                    [
                        "id" => 1396,
                        "name" => "Rings",
                    ],
                    [
                        "id" => 1322,
                        "name" => "Lady Bags",
                    ],
                    [
                        "id" => 1338,
                        "name" => "Luggage Suitcase",
                    ]
                ]
            ],
            [
                'id' => 1258,
                'name' => 'Men',
                'sub' => [
                    [
                        'id' => 1258,
                        'name' => 'Men\'s Clothing'
                    ],
                    [
                        'id' => 1300,
                        'name' => 'Men\'s Shoes'
                    ]
                ]
            ],
            [
                'id' => 1182,
                'name' => 'Women',
                'sub' => [
                    [
                        'id' => 1182,
                        'name' => 'Women\'s Clothing'
                    ],
                    [
                        'id' => 1237,
                        'name' => 'Women\'s Shoes'
                    ]
                ]
            ],
            [
                'id' => 1419,
                'name' => 'Babies & Toys',
                'sub' => [
                    [
                        'id' => 1511,
                        'name' => 'Children Shoes'
                    ],
                    [
                        'id' => 1721,
                        'name' => 'Children Toys'
                    ],
                    [
                        'id' => 1540,
                        'name' => 'Baby Products'
                    ],
                    [
                        'id' => 1432,
                        'name' => 'Children\'s Accessories'
                    ]
                ]
            ],
        ];
        return $data;
    }
}
