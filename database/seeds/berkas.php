<?php

use Illuminate\Database\Seeder;
use App\Berkas as b;

class berkas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        b::create([
            'Id_berkas' => '1',
            'Nama_berkas' =>'ijazah',
            'Harga' => '1000'
            ]);

        b::create([
            'Id_berkas' => '2',
            'Nama_berkas' =>'Transkrip nilai',
            'Harga' => '1500'
            ]);
    }
}
