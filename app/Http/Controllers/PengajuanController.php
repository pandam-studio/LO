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
    public function index(Request $r){
        $stat = $r->status;
        $search = $r->search;
        if($search){
            $status= 1;
            $pengajuan = pengajuan::with(['Alumni','Status'])->whereHas('Alumni',function($q) use($search){
                $q->Where("Nama","like","%$search%")->orWhere("No_alumni","like","%$search%");
            })->
            orderBy('Id_pengajuan','desc')->orWhere('Code','like',"%$search%")->paginate(10);
        }elseif ($stat) {
            $pengajuan = pengajuan::with(['Alumni','Status'])->
            orderBy('Id_pengajuan','desc')->Where('Id_status',$stat)->paginate(10);
        }else{
            $stat= 1;
            $pengajuan = pengajuan::with(['Alumni','Status'])->
                orderBy('Id_pengajuan','desc')->paginate(10);             
        }
       
        $status = status::orderBy('Urutan','ASC')->get();

        return view('pengajuan',['pengajuan'=>$pengajuan,'status'=>$status,
        'selected'=>$stat,'search'=>$search]);
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
                                'Nama_berkas'=>$value->Nama_berkas,
                                'Jumlah_berkas'=> $request->$nameWithOutSpace,
                                'Harga'=>$value->Harga,
                                'Harga_total'=>$request->$nameWithOutSpace*$value->Harga
                            ]);
                        }
                    }
            });
        }catch(Exception $e){
            $transaction= false;
        }
        
        if($transaction){
            $idStatus = Status::where('Urutan',1)->first()->Id_status;
            $emailJob = (new SendMailJob($idAlumni,$code, $idStatus));
            dispatch($emailJob);
            return redirect()->route('response',['id' => $idPeng]);
        }else{
            return redirect()->back()->withErrors(['msg','Failed To save']);
        }

    }

    public function response(Request $r)
    {
        $id =$r->input('id');
        $data = Berkas_Pengajuan::where('Id_pengajuan',$id)->get();
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
        $data= DB::select("SELECT pengajuan.*,berkas_pengajuan.*,berkas.Nama_berkas FROM pengajuan LEFT JOIN
                berkas_pengajuan ON pengajuan.Id_pengajuan=berkas_pengajuan.Id_pengajuan
                LEFT JOIN berkas on berkas_pengajuan.Id_berkas= berkas.Id_berkas
                WHERE pengajuan.Id_pengajuan=$idPeng");
            return response()->json($data, 200);
    }

    public function ambil(Request $r){
        $idPeng = $r->idPeng;
       
        if(DB::update('update pengajuan set Tgl_keluar = ? where Id_pengajuan = ?', [now(),$idPeng])){
            return response()->json(['success'=>true], 200);
        }else{
            return response()->json([], 200);
        }
    }
    public function updateStatus(Request $r)
    {
        $status = $r->status;
        $idPeng = $r->idPeng;
        // $pengajuan = DB::select("select * from ", [1])
       if(DB::update('update pengajuan set Id_status = ? where Id_pengajuan = ?', [$status,$idPeng])){
           if ($status==Status::orderBy('Urutan','DESC')->first()->Id_status) {
                $idStatus = Status::orderBy('Urutan','DESC')->first()->Id_status;
                $pengajuan= Pengajuan::where('Id_pengajuan',$idPeng)->first();
                $idAlumni = $pengajuan->Id_alumni;
                $code = $pengajuan->Code;
                $emailJob = (new SendMailJob($idAlumni,$code,$idStatus));
                dispatch($emailJob);
           }
        return response()->json(['success'=>true], 200);
       }else{
        return response()->json([], 200);
       }
    }
    public function downloadPDF(Request $r)
    {
        $tanggalMulai =isset($r->from) ? $r->from : '2020-07-18';
        $tanggalSelesai =isset($r->to) ? $r->to : date('Y-m-d');

        $tanggalMulai= date('Y-m-d',strtotime($tanggalMulai));
        $tanggalSelesai= date('Y-m-d',strtotime($tanggalSelesai));

        $pengajuan = Pengajuan::with('Berkas_Pengajuan','Alumni')->whereBetween('Tgl_masuk',[$tanggalMulai,$tanggalSelesai])->get();
        $berkas = Berkas::get();
        // dd($pengajuan);
        $data=[
            'tanggalMulai'=> $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'berkas'=>$berkas,
            'pengajuan'=>$pengajuan
        ];

        $pdf = PDF::loadview('downloadPDF',$data);
        return $pdf->download('laporan.pdf');
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
