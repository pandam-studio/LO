<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LOEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $Nama;
    protected $code;
     public function __construct($NamaAlumni,$code)
    {
        $this->Nama=$NamaAlumni;
        $this->code= $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $code ='tes';
        $nama=$this->Nama;
        $code=$this->code;
        return $this->from('pengirim@malasngoding.com')
                      ->view('email.notifyUser')
                      ->with(
                        [
                            'nama' => $nama,
                            'code' => $code

                        ])->subject('Permintaan legalisir');
    }
}
