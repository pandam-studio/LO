<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumni as Pengajuan;
use App\Berkas;
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
        $pengajuan = pengajuan::paginate(10);

        return view('pengajuan',['pengajuan'=>$pengajuan]);
    }
    public function laporan(){
        return view('laporan');
    }
}
