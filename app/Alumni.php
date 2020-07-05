<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'Id_alumni';

    protected $fillable = [
        'No_alumni','Nama','Email'
    ];
}
