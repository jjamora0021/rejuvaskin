<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Carbon\Carbon;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $users = [
        	[
	            'first_name' => 'John Joshua',
                'middle_name' => 'Alforte',
                'last_name' => 'Jamora',
                'email' => 'jjamora0021@gmail.com',
	            'password' => bcrypt('password'),
	            'remember_token' => Str::random(40) . time(),
	            'user_role' => 'superadmin',
                'status' => 'ACTIVE',
	            'created_at' => $now,
	            'updated_at' => $now
        	],
            [
                'first_name' => 'Maria Theressa',
                'middle_name' => 'Maniquiz',
                'last_name' => 'Maneclang',
                'email' => 'maneclangmariatheressa@yahoo.com',
                'password' => bcrypt('password'),
                'remember_token' => Str::random(40) . time(),
                'user_role' => 'manager',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        foreach ($users as $user) {
        	DB::table('users')->insert($user);
        }
    }
}
