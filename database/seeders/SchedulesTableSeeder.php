<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use DB;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $schedules = [
        	[
	            'patient_id' => 1,
                'date' => Carbon::parse('2021-02-10')->format('Y-m-d'),
                'time' => Carbon::parse('14:30:00')->format('H:i:s'),
	            'procedure' => 'Facial',
                'description' => 'Facial on patient',
                'deleted_at' => false,
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'patient_id' => 1,
                'date' => Carbon::parse('2021-02-10')->format('Y-m-d'),
                'time' => Carbon::parse('16:30:00')->format('H:i:s'),
	            'procedure' => 'Botux',
                'description' => 'Botux procedure on patient',
                'deleted_at' => false,
	            'created_at' => $now,
	            'updated_at' => $now
            ],
        ];

        foreach ($schedules as $scheds) {
        	DB::table('schedules')->insert($scheds);
        }
    }
}
