<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'login_id' => 'admin',
            'name' => 'admin',
            'cell' => '13888888888',
            'pwd' => hash('sha256', '111111'),
            'status' => 1,
            'lock_status' => 1, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
