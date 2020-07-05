<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'Id_pengajuan';

    protected $fillable = [
        'Id_alumni','Id_status','Tgl_masuk','Tgl_keluar'
    ];
    //
}
