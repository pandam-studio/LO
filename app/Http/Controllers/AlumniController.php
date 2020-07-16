<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Alumni;

class AlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function cekAlumni(Request $req)
    {
        $alumni= Alumni::firstWhere('No_alumni', $req->no_alumni);

        if($alumni!=null){
            $data = ['status'=>'200' ,'nama'=>$alumni->Nama,'email'=>$alumni->Email];
        }
        else{
            $data = ['status'=>'500'];
        }

        return response()->json($data, 200);

    }

}
