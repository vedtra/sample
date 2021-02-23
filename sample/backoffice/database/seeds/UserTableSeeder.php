<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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
            'name' => 'Administrator',
            'email' => 'admin@coniolabs.com',
            'password' => bcrypt('rahasia'),
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
    }
}
