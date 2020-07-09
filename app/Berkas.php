<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table='berkas';
    public $timestamps = false;

    protected $primaryKey = 'Id_berkas';

    protected $fillable = [
        'Nama_berkas','Harga'
    ];
}
