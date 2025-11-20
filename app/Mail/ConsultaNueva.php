<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

//Esta clase representa un correo electrónico que se enviará cuando un cliente envíe una consulta desde la web
class ConsultaNueva extends Mailable
{
    use Queueable, SerializesModels;
    //se guardan datos para pasarlo como un array solo
    public $data;

    /**
     * Recibe el array con los datos enviados desde el formulario de contacto y los asigna a propiedades individuales
     */
    public function __construct($data)
    {
        $this->nombre = $data['nombre'];
        $this->telefono = $data['telefono'];
        $this->email = $data['email'];
        $this->mensaje = $data['mensaje'];
    }

    /**
     * Defino el asunto
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mensaje de Cliente Web',
        );
    }

    /**
     * Defino el contenido del correo
     */
    public function content(): Content
    {
        return new Content( //modificar el .env con los datos de la bandeja de correo, ese será el emisor (remitente)
        view: 'emails.consultaNueva', with: [ //pasa las variables necesarias a la vista
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'mensaje' => $this->mensaje,
            ],
        );
    }

    /**
     * Este correo no contiene adjuntos
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
