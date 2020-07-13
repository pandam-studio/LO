<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Pengajuan;
use App\Berkas;
use App\Berkas_Pengajuan;
use App\Alumni;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //tampilan form input
     public function index()
    {
        $berkas = berkas::all();
        return view('home',['berkas'=>$berkas]);
    }

    //insert pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'noalumni' => 'required',
            'nama' => 'required',
            'email' => 'required|email'
        ]);

        
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

    //tampilan daftar pengajuan
    public function pengajuan(){
        // $pengajuan = pengajuan::with(['Alumni','Status','Berkas_Pengajuan','ThroughBerkas'])->orderBy('Id_pengajuan','desc')->paginate(10);

        $pengajuan = alumni::paginate(10);
        return view('pengajuan',['pengajuan'=>$pengajuan]);
    }



    public function laporan(){
        return view('laporan');
    }
}
