<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table='alumni';
    public $timestamps = false;

    protected $primaryKey = 'Id_alumni';

    protected $fillable = [
        'No_alumni','Nama','Email'
    ];
}
