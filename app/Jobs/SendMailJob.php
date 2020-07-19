<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\LOEmail;
use Illuminate\Support\Facades\Mail;
use App\Alumni;

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
     protected $keterangan;
    public function __construct($idAlumni,$code,$keterangan)
    {
        $this->idAlumni = $idAlumni;
        $this->code = $code;
        $this->keterangan = $keterangan;
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
        $keterangan = $this->keterangan;
        $alumni= Alumni::where('Id_alumni',$id)->first();
        // $alumni->Email
        Mail::to($alumni->Email)->
        send(new LOEmail($alumni->Nama,$code,$keterangan));
    }
}
