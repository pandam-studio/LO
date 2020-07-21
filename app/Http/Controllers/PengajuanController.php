<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\Pengajuan;
use App\Berkas;
use App\Berkas_Pengajuan;
use App\Alumni;
use App\Status;
class PengajuanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //tampilan daftar pengajuan
    public function index(){
        $pengajuan = pengajuan::with(['Alumni','Status'])->
        orderBy('Id_pengajuan','desc')->paginate(10);
        $status = status::orderBy('Urutan','ASC')->get();
        return view('pengajuan',['pengajuan'=>$pengajuan,'status'=>$status]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'noalumni' => 'required',
            'nama' => 'required',
            'email' => 'required|email'
        ]);

        $idPeng = 0;
        $idAlumni=0;
        $code = "";
        $transaction =true;//success
        try{
            DB::transaction(function() use($request,&$idPeng,&$code,&$idAlumni) {
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
                $code = $Pengajuan->Code;
                $idAlumni = $alumni->Id_alumni;
                $berkas = Berkas::all();
                    foreach ($berkas as $key => $value) {
                        $nameWithOutSpace = str_replace(' ','',$value->Nama_berkas);
                        if ($jmlberkas= $request->$nameWithOutSpace) {
                            Berkas_Pengajuan::Create([
                                'Id_pengajuan'=> $Pengajuan->Id_pengajuan,
                                'Id_berkas'=> $value->Id_berkas,
                                'Jumlah_berkas'=> $request->$nameWithOutSpace,
                                'Harga'=>$value->Harga
                            ]);
                        }
                    }
            });
        }catch(Exception $e){
            $transaction= false;
        }
        
        if($transaction){
            $keterangan = Status::where('Urutan',1)->first()->Keterangan;
            $emailJob = (new SendMailJob($idAlumni,$code, $keterangan));
            dispatch($emailJob);
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

    public function delete($id){
        DB::delete('delete from pengajuan where Id_pengajuan = ?', [$id]);
    }

    public function getDetail(Request $req)
    {
        $idPeng = $req->Id_pengajuan;
        $data= DB::select("SELECT pengajuan.*,berkas_pengajuan.* FROM pengajuan LEFT JOIN
                berkas_pengajuan ON pengajuan.Id_pengajuan=berkas_pengajuan.Id_pengajuan
                WHERE pengajuan.Id_pengajuan=$idPeng");
            return response()->json($data, 200);
    }

    public function updateStatus(Request $r)
    {
        $status = $r->status;
        $idPeng = $r->idPeng;
        // $pengajuan = DB::select("select * from ", [1])
       if(DB::update('update pengajuan set Id_status = ? where Id_pengajuan = ?', [$status,$idPeng])){
           if ($status==Status::orderBy('Urutan','DESC')->first()->Id_status) {
                $keterangan = Status::orderBy('Urutan','DESC')->first()->Keterangan;
                $pengajuan= Pengajuan::where('Id_pengajuan',$idPeng)->first();
                $idAlumni = $pengajuan->Id_alumni;
                $code = $pengajuan->Code;
                $emailJob = (new SendMailJob($idAlumni,$code,$keterangan));
                dispatch($emailJob);
           }
        return response()->json(['success'=>true], 200);
       }else{
        return response()->json([], 200);
       }
    }
    public function downloadPDF(Request $r)
    {
        $tanggalMulai =isset($r->from)?$r->from:'2020-07-18';
        $tanggalSelesai =isset($r->to)?$r->to:date('Y-m-d');
        $pengajuan = Pengajuan::with('Berkas_Pengajuan','Alumni')->whereBetween('Tgl_masuk',[$tanggalMulai,$tanggalSelesai])->get();
        $berkas = Berkas::get();
        $data=[
            'tanggalMulai'=> $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'berkas'=>$berkas,
            'pengajuan'=>$pengajuan
        ];

        $pdf = PDF::loadview('downloadPDF',$data);
        return $pdf->download('laporan-pegawai.pdf');
    }

    public function laporan(Request $r){

        $from = isset($r->from)?$r->from :'22/06/2020';
        $to = isset($r->to) ? $r->to : now();

        $idSiapDiambil = Status::orderBy('Urutan','DESC')->first()->Id_status;
        $done = Pengajuan::where('Tgl_keluar','!=',null)->count();
        $rtp = Pengajuan::where([['Id_status',$idSiapDiambil],['Tgl_keluar',null]])->count();
        $op = Pengajuan::where([['Id_status','!=',$idSiapDiambil],['Tgl_keluar',null]])->count();
        $pengajuan = Pengajuan::with('Berkas_Pengajuan','Alumni')->whereBetween('Tgl_masuk',['2020-05-1','2020-06-30'])->get();
        $data =array(
            'from'=>date('d/M/Y'),
            'to'=>date('Y'),
            'rtp'=>$rtp,
            'op'=>$op,
            'done'=> $done,
                 );
        return view('laporan',$data);
    }
}
