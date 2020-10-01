<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateUserTableSeeder::class);
        $this->call(CreatePostTableSeeder::class);
        // $this->call(CreateUserTableSeeder::class);
        // $this->call(CreateUserTableSeeder::class);
        // $this->call(CreateUserTableSeeder::class);
    }
}
