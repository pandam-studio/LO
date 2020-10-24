<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use DB;
use App\Berkas;
class BerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
        $berkas= Berkas::all();
        return view('berkas.index',['berkas'=>$berkas,'i'=>1]);
    }
    function delete($id){
        Berkas::destroy($id);
    }

    function store(Request $r){
        if ($r->id!="") {
            $x= Berkas::updateOrCreate(['Id_berkas'=>$r->id],['Nama_berkas'=>$r->nama,'Harga'=>$r->harga]);
            $message = "data berhasil diperbarui!";  
        }else{
            $x= Berkas::create([
                'Nama_berkas' => $r->nama,
                'Harga' => $r->harga]);  
            $message = "data berhasil ditambahkan!";  
        }

        if($x){
            return response()->json(['result'=>'success','message'=>$message,'messageTitle'=>'Success !'],200);
        }else{
            return response()->json(['result'=>'error','message'=>'Please try again!','messageTitle'=>'Error !'],200);
        }
    }
}
