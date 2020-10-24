<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class alumni extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i=0;$i<100;$i++){

            DB::table('Alumni')->insert([
                'No_alumni' => $faker->numberBetween(1000,100000),
                'Nama' => $faker->name,
                'email' => $faker->email
                ]);
            }
        //
    }
}
