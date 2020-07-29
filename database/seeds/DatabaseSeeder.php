<?php

use Illuminate\Database\Seeder;
use App\User;
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
        $this->call(statusSeeder::class);

        User::create([
            'id_user'=>1,
            'nik'=>'220696',
            'nama'=>'versta',
            'email'=>'versta@ummgl.ac.id',
            'password'=> Hash::make('qweasd')
        ]);
        // $this->call(UserSeeder::class);
    }
}
