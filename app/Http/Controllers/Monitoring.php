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

        $data= DB::select('SELECT status.* FROM status RIGHT JOIN pengajuan ON status.Id_status=pengajuan.Id_status where pengajuan.code = ?', [$code]);

        if(!empty($data)){
            return response()->json($data[0], 200);
        }else{
            return response()->json([], 200);
        }

    }
}
