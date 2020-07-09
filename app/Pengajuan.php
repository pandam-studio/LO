<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table='pengajuan';
    public $timestamps = false;

    protected $primaryKey = 'Id_pengajuan';

    protected $fillable = [
        'Id_alumni','Id_status','Tgl_masuk','Tgl_keluar'
    ];

    public function Alumni()
    {
        return $this->belongsTo('App\Alumni','Id_alumni');
    }

    public function Status()
    {
        return $this->hasOne('App\Status', 'Id_status');

    }

    public function Berkas_pengajuan()
    {
        return $this->hasMany('App\Berkas_Pengajuan', 'Id_berkaspengajuan');
    }
}
