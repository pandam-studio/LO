<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengajuan;
use App\Berkas;
use App\Berkas_Pengajuan;
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
    public function index()
    {
        $berkas = berkas::all();
        return view('home',['berkas'=>$berkas]);
    }

    public function pengajuan(){
        $pengajuan = pengajuan::with(['Alumni','Status','Berkas_Pengajuan'])->paginate(10);
        return view('pengajuan',['pengajuan'=>$pengajuan]);
    }
    public function laporan(){
        return view('laporan');
    }
}
