<?php

use Illuminate\Database\Seeder;
Use App\Status;
class statusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'Keterangan'=>'Berkas Diterima Di TU',
            'Urutan'=>1
        ]);
        Status::create([
            'Keterangan'=>'Pengajuan Berkas Ke Dekan',
            'Urutan'=>2
        ]);
        Status::create([
            'Keterangan'=>'Berkas Siap Diambil',
            'Urutan'=>3
        ]);
    
    }
}
