<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admin=User::get();
        return view('admin.index',['admin'=>$admin,'i'=>1]);
    }

    function delete($id){
        if($id!=1){
        DB::delete('delete from user where id_user = ?', [$id]);
        }
    }

    function store(Request $r){
        if ($r->password!=$r->password1) {
            return response()->json(['result'=>'error','message'=>'Password tidak sama!','messageTitle'=>'Error !'],200);
            die;
        }
        if ($r->id!="") {
            $x= User::updateOrCreate(['id_user'=>$r->id],
                ['nik'=>$r->nik,
                'nama'=>$r->nama,
                'email'=>$r->email,
                'password'=>Hash::make($r->password)]);
            $message = "data berhasil diperbarui!";  
        }else{
            $x= User::create([
                'nik'=>$r->nik,
                'nama'=>$r->nama,
                'email'=>$r->email,
                'password'=>Hash::make($r->password)
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
