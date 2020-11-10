<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Alumni;
use DataTables;

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

    public function index()
    {
        $alumni= Alumni::get();
        return view('alumni.index',['alumni'=>$alumni,'i'=>1]);
    }
    public function getAlumni(){
  
        return datatables()->of(DB::table('alumni'))->toJson();
    
    }

    function delete($id){
        Alumni::destroy($id);
    }

    function store(Request $r){
    
        if ($r->id!="") {
            $x= Alumni::updateOrCreate([
                'Id_alumni'=>$r->id],
                ['No_alumni'=>$r->noAlumni,
                'Nama'=>$r->nama,
                'Email'=>$r->email]);
            $message = "data berhasil diperbarui!";  
        }else{
            $x= Alumni::create([
                'Id_alumni'=>$r->id,
                'No_alumni'=>$r->noAlumni,
                'Nama'=>$r->nama,
                'Email'=>$r->email
                ]);  
            $message = "data berhasil ditambahkan!";  
        }

        if($x){
            return response()->json(['result'=>'success','message'=>$message,'messageTitle'=>'Success!'],200);
        }else{
            return response()->json(['result'=>'error','message'=>'Please try again!','messageTitle'=>'Error!'],200);
        }
    }
}
