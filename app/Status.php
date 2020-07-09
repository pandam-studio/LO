<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table='status';
    public $timestamps = false;

    protected $primaryKey = 'Id_status';

    protected $fillable = [
        'Keterangan','urutan'
    ];
    public function Pengajuan()
    {
        return $this->belongsTo('App\Pengajuan', 'Id_status');
    }
}
