<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
            'role_id' => '1',
            'name' => 'Mr.Admin',
            'phone' => '078343143',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Phagna@sa')
       ]);
       User::create([
            'role_id' => '2',
            'name' => 'Mr.Author',
            'phone' => '070393143',
            'username' => 'author',
            'email' => 'author@gmail.com',
            'password' => bcrypt('Phagna@sa')
       ]);
    }
}
