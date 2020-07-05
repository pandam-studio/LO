<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'Id_status';

    protected $fillable = [
        'Keterangan','urutan'
    ];
    //
}
