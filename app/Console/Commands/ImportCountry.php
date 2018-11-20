<?php

namespace App\Console\Commands;

use App\Entities\Country\CountryArea;
use Illuminate\Console\Command;

class ImportCountry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:country {--y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import country state city and so on...';

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
        if ($this->option('y')) {
            $this->handleProgress();
        } else {
            if ($this->confirm('Do you want to continue? [y|N]')) {
                $this->handleProgress();
            }
        }
    }

    public function handleProgress()
    {
        $files = [
            '孟加拉Bangladesh省市.xlsx'
        ];
        foreach ($files as $file) {
            $path = storage_path('excel/import/country/' . $file);
            \Excel::load($path, function ($reader) use ($file) {
                $areas = $reader->getSheet(0)->toArray();
                array_shift($areas);
                foreach ($areas as $area) {
                    $country = CountryArea::firstOrCreate(['name' => $area[0], 'parent_id' => 0]);
                    $state = CountryArea::firstOrCreate(['name' => $area[1], 'parent_id' => $country['id']]);
                    $areaModel = CountryArea::firstOrCreate(['name' => $area[2], 'parent_id' => $state['id']]);
                    $this->info('add-' . $area[0] . '-' . $area[1] . '-' . $area[2]);
                }
            });
        }
    }
}
