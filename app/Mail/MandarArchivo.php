<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MandarArchivo extends Mailable
{
    use Queueable, SerializesModels;
    public $email,$path;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email,string $path)
    {
        $this->email=$email;
        $this->path=$path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Correos.MandarArchivos')->attachFromStorageDisk('public',$this->path);;
    }
}
