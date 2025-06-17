<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultaNueva extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->nombre = $data['nombre'];
        $this->telefono = $data['telefono'];
        $this->email = $data['email'];
        $this->mensaje = $data['mensaje'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mensaje de Cliente Web',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content( //modificar el .env con los datos de la bandeja de correo, ese sera el emisor (remitente)
        view: 'emails.consultaNueva', with: [
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'mensaje' => $this->mensaje,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
