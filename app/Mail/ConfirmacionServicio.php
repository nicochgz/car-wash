<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmacionServicio extends Mailable
{
    use Queueable, SerializesModels;


    var $objeto;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($x)
    {
        //
        $this->objeto=$x;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //From se define desde que cuenta se va a enviar el correo
        return $this->from('servicios@carwash.com')
        //Definir la vista html que tiene el contenido del correo
                ->view('email.confirmacion_servicio');
    }
}
