<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PickupNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $Nama;
    protected $code;
    protected $keterangan;

    public function __construct($NamaAlumni,$code,$keterangan)
    {
        $this->Nama=$NamaAlumni;
        $this->code= $code;
        $this->keterangan= $keterangan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $nama=$this->Nama;
        $code=$this->code;
        $keterangan=$this->keterangan;
        
        return $this->from('Teknik@ummgl.ac.id')
                      ->view('email.pickupNotify')
                      ->with(
                        [
                            'nama' => $nama,
                            'code' => $code,
                            'keterangan' => $keterangan
                        ])->subject('Informasi Legalisir');
    }
}
