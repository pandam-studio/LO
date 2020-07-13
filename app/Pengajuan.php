<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table='pengajuan';
    public $timestamps = false;

    protected $primaryKey = 'Id_pengajuan';

    protected $fillable = [
        'Id_alumni','Id_status','Tgl_masuk','Tgl_keluar','code'
    ];

    public function Alumni()
    {
        return $this->belongsTo('App\Alumni','Id_alumni');
    }

    public function Status()
    {
        return $this->hasOne('App\Status', 'Id_status');

    }

    public function Berkas_Pengajuan()
    {
        return $this->hasMany('App\Berkas_Pengajuan', 'Id_pengajuan');
    }

    public function ThroughBerkas()
    {
        return $this->hasManyThrough(
            'App\Berkas',
            'App\Berkas_Pengajuan',
            'Id_pengajuan', // Foreign key on cars table...
            'Id_berkas', // Foreign key on owners table...
            'Id_pengajuan', // Local key on mechanics table...
            'Id_berkaspengajuan' // Local key on cars table...
        );
    }
}
