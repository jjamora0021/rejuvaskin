<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use DB;

class TimeKeepingRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $time_sheet = [
        	[
	            'id' => 1,
                'emp_id' => 1,
                'date' => Carbon::parse('2021-02-10'),
                'time_in' => '09:00:00',
                'time_out' => '16:00:00',
	            'total_hours' => abs(strtotime('16:00:00') - strtotime('09:00:00'))/(60*60),
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'id' => 2,
                'emp_id' => 1,
                'date' => Carbon::parse('2021-02-11'),
                'time_in' => '09:00:00',
                'time_out' => '16:00:00',
	            'total_hours' => abs(strtotime('16:00:00') - strtotime('09:00:00'))/(60*60),
	            'created_at' => $now,
	            'updated_at' => $now
            ],
        ];

        foreach ($time_sheet as $time) {
        	DB::table('time_keeping_records')->insert($time);
        }
    }
}
