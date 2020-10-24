<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table='Alumni';
    public $timestamps = false;

    protected $primaryKey = 'Id_alumni';

    protected $fillable = [
        'No_alumni','Nama','Email'
    ];

    public function Pengajuan()
    {
        return $this->hasOne('App\Pengajuan','Id_alumni');
    }
}
