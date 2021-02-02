<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Monitoring extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function findCode(Request $r)
    {
        $code= $r->code;

        $data= DB::select('SELECT Status.*,Pengajuan.* FROM Status RIGHT JOIN Pengajuan ON Status.Id_status=Pengajuan.Id_status where Pengajuan.code = ?', [$code]);

        if(!empty($data)){
            return response()->json($data[0], 200);
        }else{
            return response()->json([], 200);
        }

    }
}
