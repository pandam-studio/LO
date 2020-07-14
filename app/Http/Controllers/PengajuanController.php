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

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'noalumni' => 'required',
            'nama' => 'required',
            'email' => 'required|email'
        ]);

        $idPeng = 0;
        $transaction =true;//success
        try{
            DB::transaction(function() use($request,&$idPeng) {
                $alumni = Alumni::updateOrCreate(
                    ['No_alumni'=> $request->noalumni],
                    ['Nama'=> $request->nama,
                    'Email' => $request->email]
                    );

                $Pengajuan = Pengajuan::create([
                    'Id_alumni'=>$alumni->Id_alumni,
                    'Id_status'=>Status::where('Urutan',1)->first()->Id_status,
                    'Tgl_masuk'=>Carbon::now(),
                    'Code'=> Str::random(10)
                    ]);

                $idPeng = $Pengajuan->Id_pengajuan;

                $berkas = Berkas::all();
                    foreach ($berkas as $key => $value) {
                        $nameWithOutSpace = str_replace(' ','',$value->Nama_berkas);
                        if ($jmlberkas= $request->$nameWithOutSpace) {
                            Berkas_Pengajuan::Create([
                                'Id_pengajuan'=> $Pengajuan->Id_pengajuan,
                                'Id_berkas'=> $value->Id_berkas,
                                'Jumlah_berkas'=> $request->$nameWithOutSpace
                            ]);
                        }
                    }
            });
        }catch(Exception $e){
            $transaction= false;
        }

        if($transaction){
            return redirect()->route('response',['id' => $idPeng]);
        }else{
            return redirect()->back()->withErrors(['msg','Failed To save']);
        }

    }

    public function response(Request $r)
    {
        $id =$r->input('id');
        $data = DB::select("select berkas_pengajuan.* , berkas.* from berkas_pengajuan join berkas on berkas_pengajuan.Id_berkas=berkas.Id_berkas where berkas_pengajuan.Id_pengajuan=?",[$id]);
        if($data){
            return view('response',['data'=>$data]);
        }else{
            return redirect()->route('home');
        }
    }
}
