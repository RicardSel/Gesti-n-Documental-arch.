<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudPedido extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $detalle_pedidos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $detalle_pedidos)
    {
        $this->pedido = $pedido;
        $this->detalle_pedidos = $detalle_pedidos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.solicitud_pedido')
            ->subject('Solicitud de Pedido');
    }
}
