<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berkas_Pengajuan extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'Id_berkaspengajuan';

    protected $fillable = [
        'Id_berkas','Jumlah_berkas'
    ];
}
