<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berkas_Pengajuan extends Model
{
    protected $table='berkas_pengajuan';

    public $timestamps = false;

    protected $primaryKey = 'Id_berkaspengajuan';

    protected $fillable = [
       'Id_pengajuan', 'Id_berkas','Jumlah_berkas'
    ];

    public function Berkas()
    {
        return $this->belongsTo('App\Berkas','Id_berkas');
    }
    public function Pengajuan()
    {
        return $this->belongsTo('App\Pengajuan', 'Id_pengajuan');

    }
}
