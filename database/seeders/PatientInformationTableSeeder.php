<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Carbon\Carbon;
use DB;

class PatientInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $patients = [
        	[
        		'id' => 1,
	            'first_name' => 'John Joshua',
                'middle_name' => 'Alforte',
                'last_name' => 'Jamora',
                'birth_date' => '02/15/2021',
	            'gender' => 'male',
	            'home_number' => null,
	            'mobile_number' => '9778221747',
                'email' => 'jjamora0021@gmail.com',
                'address' => '37 Cattleya Street',
                'deleted_at' => false,
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'id' => 2,
	            'first_name' => 'Tere',
                'middle_name' => '',
                'last_name' => 'Maneclang',
                'birth_date' => '12/15/2021',
	            'gender' => 'female',
	            'home_number' => null,
	            'mobile_number' => '9778221747',
                'email' => 'jjamora0021@gmail.com',
                'address' => 'Makati City',
                'deleted_at' => false,
	            'created_at' => $now,
	            'updated_at' => $now
            ],
            [
                'id' => 3,
	            'first_name' => 'Test',
                'middle_name' => '',
                'last_name' => 'Test',
                'birth_date' => '08/15/2021',
	            'gender' => 'male',
	            'home_number' => null,
	            'mobile_number' => '9778221747',
                'email' => 'jjamora0021@gmail.com',
                'address' => 'Makati City',
                'deleted_at' => false,
	            'created_at' => $now,
	            'updated_at' => $now
            ]
        ];

        foreach ($patients as $ptx) {
        	DB::table('patient_information')->insert($ptx);
        }
    }
}
