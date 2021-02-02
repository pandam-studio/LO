<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\LOEmail;
use App\Mail\PickupNotify;
use App\Mail\Diambil;
use Illuminate\Support\Facades\Mail;
use App\Alumni;
use App\Status;
class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $idAlumni;
     protected $code;
     protected $idStatus;
    public function __construct($idAlumni,$code,$idStatus)
    {
        $this->idAlumni = $idAlumni;
        $this->code = $code;
        $this->idStatus = $idStatus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id =$this->idAlumni;
        $code =$this->code;
        $idStatus = $this->idStatus;
        $status = Status::find($idStatus);
        $alumni= Alumni::where('Id_alumni',$id)->first();
        $keterangan= $status->Keterangan;
        if($status->Urutan==1||$status->Urutan==2){
            Mail::to($alumni->Email)->
            send(new LOEmail($alumni->Nama,$code,$keterangan));
        }else if($idStatus==9){
            Mail::to($alumni->Email)->
            send(new Diambil($alumni->Nama,$code,"berkas diambil"));
        }else{
            Mail::to($alumni->Email)->
            send(new PickupNotify($alumni->Nama,$code,$keterangan));
        }
    }
}
