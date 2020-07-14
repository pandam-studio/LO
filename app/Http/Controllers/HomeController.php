<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Pengajuan;
use App\Berkas;
use App\Berkas_Pengajuan;
use App\Alumni;
use App\Status;
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
        $berkas = Berkas::all();
        return view('home',['berkas'=>$berkas]);
    }

    //tampilan daftar pengajuan
    public function pengajuan(){
        $pengajuan = pengajuan::with(['Alumni','Status'])->
        orderBy('Id_pengajuan','desc')->paginate(10);
        return view('pengajuan',['pengajuan'=>$pengajuan]);
    }

    public function laporan(){
        return view('laporan');
    }
}
