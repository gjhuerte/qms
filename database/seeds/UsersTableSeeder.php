<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::truncate();
        App\User::insert(array(
        	[
        		'email' => 'johndoe@email.com',
        		'password' => Hash::make('123456789'),
        		'name' => 'John Doe',
        		'created_at' => Carbon\Carbon::now(),
        	]
        ));
    }
}
