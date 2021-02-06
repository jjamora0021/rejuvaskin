<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use DB;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $medicine = [
        	[
	            'medicine' => 'Med 1',
                'stocks' => '50',
                'stocks_delivered' => null,
	            'delivery_date' => null,
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'medicine' => 'Med 2',
                'stocks' => '124',
                'stocks_delivered' => null,
	            'delivery_date' => null,
	            'created_at' => $now,
	            'updated_at' => $now
            ],
            [
                'medicine' => 'Med 3',
                'stocks' => '190',
                'stocks_delivered' => null,
	            'delivery_date' => null,
	            'created_at' => $now,
	            'updated_at' => $now
            ],
            [
                'medicine' => 'Med 4',
                'stocks' => '25',
                'stocks_delivered' => null,
	            'delivery_date' => null,
	            'created_at' => $now,
	            'updated_at' => $now
            ],
            [
                'medicine' => 'Med 5',
                'stocks' => '13',
                'stocks_delivered' => null,
	            'delivery_date' => null,
	            'created_at' => $now,
	            'updated_at' => $now
            ],
        ];

        foreach ($medicine as $meds) {
        	DB::table('inventories')->insert($meds);
        }
    }
}
