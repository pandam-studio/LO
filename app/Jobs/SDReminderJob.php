<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SevenDayReminder;
use App\Alumni;
use App\Status;
class SDReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        Mail::to($alumni->Email)->
        send(new SevenDayReminder($alumni->Nama,$code,$keterangan));
    
    }
}
