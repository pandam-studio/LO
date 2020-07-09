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
        $this->call(alumni::class);
        $this->call(berkas::class);

        // $this->call(UserSeeder::class);
    }
}
